import React, { useEffect, useState } from 'react';
import styled from '@emotion/styled';
import { Row, Col, FormGroup, Form, Label, Input, InputGroup } from "reactstrap";
import { useDropzone } from 'react-dropzone';
import { sessionActions } from "../../actions/Dropzone/SessionActions";
import DrozoneStore from '../../stores/Dropzone/DropzoneStore';
import { dropzoneConstants } from "../../../Shared/constants/DropzoneConstants";
import {AlertComponent} from "../Alert/AlertComponent";

const DropSection = styled.div`
    background-color: #fff;
    padding: 45px 40px 40px;
    border: dotted 3px #ccc;
    border-radius: 5px;
    cursor: pointer;
`;

const PreviewSection = styled.div`
    margin-top: 20px;
`;

const ThumbsContainer = styled.div`
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    margin-top: 20px;
`;

const Thumb = styled.div`
    border-radius: 2px;
    border: 1px solid #eaeaea;
    margin-bottom: 8px;
    margin-right: 8px;
    width: auto;
    height: auto;
    padding: 4px;
    overflow: hidden;
    box-sizing: border-box;
`;

const ThumbInner = styled.div`
    display: flex;
    min-width: 0;
    overflow: hidden;
`;

const Img = styled.img`
    display: block;
    height: 140px;
`;

const Placeholder = styled.p`
    color: #ccc;
`;

const ButtonSection = styled.div`
    display: flex;
    flex-direction: row;
    justify-content: center;
    padding: 0;
    margin-top: 10px;
    
`;
export const DropzoneComponent = () => {
    const [files, setFiles] = useState([]);
    const [tags, setTags] = useState([]);
    const [filesInBase64, setFilesInBase64] = useState([]);
    const [status, setStatus] = useState({});

    const {getRootProps, getInputProps} = useDropzone({
        accept: 'image/jpeg, image/png',
        onDrop: acceptedFiles => {
            setFiles(acceptedFiles);
            setTags([
                ...tags,
                {
                    tag: ''
                }
            ]);
            setFilesInBase64(transformToBase64(acceptedFiles));
        }
    });

    useEffect(() => {
        DrozoneStore.on(dropzoneConstants.UPLOAD_SUCCESS, handleSuccess);
        DrozoneStore.on(dropzoneConstants.UPLOAD_ERROR, handleError);
        return function cleanup() {
            DrozoneStore.removeListener(dropzoneConstants.UPLOAD_SUCCESS, handleSuccess);
            DrozoneStore.removeListener(dropzoneConstants.UPLOAD_ERROR, handleError);
        };

    });

    const handleInputChange = (event, index) => {
        tags[index] = event.target.value;
        setTags([
            ...tags
        ]);
    };

    const transformToBase64 = (files) => {
        let filesEncoded = [];
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.addEventListener('load', () => {
                const binaryString = reader.result;
                filesEncoded.push({
                    base64: btoa(binaryString),
                    type: file.type,
                    index: index
                });
            });

            reader.readAsBinaryString(file);
        });

        return filesEncoded;

    };

    const createJsonItem = (file, tag, type) => {
        return {
            tag: tag,
            type: type,
            file: file
        };
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        if(files && tags) {
            let json = [];

            filesInBase64.forEach(file => {
                let jsonItem = createJsonItem(file.base64, tags[file.index], file.type);
                json.push(jsonItem);
            });

            sessionActions.upload(JSON.stringify(json));
        }

    };

    const handleSuccess = () => {
        let response = DrozoneStore.getResponse();
        restartAllStates();
        setStatus(response);
        setTimeout(restartStatus, 5000);
    };

    const handleError = () => {
        let response = DrozoneStore.getResponse();
        restartAllStates();
        setStatus(response);
        setTimeout(restartStatus, 5000);
    };

    const restartAllStates = () => {
        setFiles([]);
        setFilesInBase64([]);
        setTags([]);
    };

    const restartStatus = () => {
        setStatus({});
    };

    const thumbs = files.map((file, index) => (
        <Col xs={'4'} key={index}>
            <Row>
                <Col xs={'12'} className={'d-flex justify-content-center'}>
                    <Thumb>
                        <ThumbInner>
                            <Img src={URL.createObjectURL(file)} />
                        </ThumbInner>
                    </Thumb>
                </Col>
            </Row>
            {
                tags && tags.length > 0 ?
                    <FormGroup>
                        <Label for={`tag-${index}`}>🏷 Tag</Label>
                        <Input
                            onChange={(event) => handleInputChange(event, index)}
                            value={tags.tag}
                            type={'text'}
                            id={`tag-${index}`}
                            placeholder={'Type a tag name'}
                            autoComplete={'on'}
                        />
                    </FormGroup> : null
            }
        </Col>

    ));

    return (
        <Row>
            <Col xs={'12'}>
                <h4>Add files 📷</h4>
                <DropSection id={'dropSection'} className={'d-flex justify-content-center align-items-center'} {...getRootProps()}>
                    <input {...getInputProps()} />
                    <Placeholder className={'m-0'}>Drag and drop some files here, or click to select files</Placeholder>
                </DropSection>
                {
                    files && files.length > 0 ?
                        <PreviewSection>
                            <Row>
                                <Col>
                                    <h4>Photos</h4>
                                    <Form onSubmit={handleSubmit} id={'filesToUpload'}>
                                        <ThumbsContainer>
                                            {thumbs}
                                        </ThumbsContainer>
                                        <ButtonSection className={'col-12'}>
                                            <input className={'col-3 btn btn-dark'} type='submit' value='Upload'/>
                                        </ButtonSection>
                                    </Form>
                                </Col>
                            </Row>
                        </PreviewSection> : null
                }
                <AlertComponent status={status} />
            </Col>
        </Row>
    );
};
