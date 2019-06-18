import React, { useEffect, useState } from 'react';
import styled from '@emotion/styled';
import { Row, Col, FormGroup, Form, Label, Input } from "reactstrap";
import { useDropzone } from 'react-dropzone';
import { sessionActions } from "../../actions/Dropzone/SessionActions";
import DrozoneStore from '../../stores/Dropzone/DropzoneStore';
import { dropzoneConstants } from "../../../Shared/constants/DropzoneConstants";

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
    width: 150px;
    height: 150px;
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
    width: 100%;
    height: 100%;
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
        DrozoneStore.on(dropzoneConstants.UPLOAD_SUCCESS, handleResponse);
        return function cleanup() {
            DrozoneStore.removeListener(dropzoneConstants.UPLOAD_SUCCESS, handleResponse);
        };

    });

    const handleInputChange = (event, index) => {
        tags[index] = event.target.value;
        setTags([
            ...tags
        ]);
    };

    const handleSubmit = (event) => {
        event.preventDefault();

        if(files && filesInBase64 && tags) {
            let json = {
                files: []
            };

            filesInBase64.forEach((file, index) => {
                let jsonItem = createJsonItem(file, tags[index], files[index].type);
                json.files.push(jsonItem);
            });

            sessionActions.upload(json);
        }

    };

    const handleResponse = () => {
        let response = DrozoneStore.getResponse();
        console.log(response.data);

    };

    const createJsonItem = (file, fileTag, type) => {
        return JSON.stringify({
            tag: fileTag,
            type: type,
            file: file
        });

    };

    const transformToBase64 = files => {
        let filesEncoded = [];

        files.forEach(file => {
            let reader = new FileReader();
            reader.addEventListener('load', () => {
                let binaryString = reader.result;
                filesEncoded.push(btoa(binaryString));
            }, false);
            reader.readAsBinaryString(file);
        });

        return filesEncoded;

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
                        <Label for={`tag-${index}`}>Tag</Label>
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
                <DropSection className={'d-flex justify-content-center align-items-center'} {...getRootProps()}>
                    <input {...getInputProps()} />
                    <Placeholder className={'m-0'}>Drag 'n' drop some files here, or click to select files</Placeholder>
                </DropSection>
                {
                    files && files.length > 0 ?
                        <PreviewSection>
                            <Row>
                                <Col>
                                    <h3>Photos</h3>
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
            </Col>
        </Row>
    );
};
