import React, { useEffect, useState } from 'react';
import { Row, Col } from "reactstrap";
import SearchStore from "../../stores/Search/SearchStore";
import { searchConstants } from "../../../Shared/constants/SearchConstants";
import styled from "@emotion/styled";

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

export const ResultsComponent = () => {

    const [files, setFiles] = useState([]);

    useEffect(() => {
        SearchStore.on(searchConstants.SEARCH_SUCCESS, handleSuccess);
        return function cleanup() {
            SearchStore.removeListener(searchConstants.SEARCH_SUCCESS, handleSuccess);
        };

    });

    const handleSuccess = () => {
        let apiResponse = SearchStore.getResponse();

        if (!Array.isArray(apiResponse.data)){
            setFiles([ apiResponse.data ]);
        } else {
            setFiles(apiResponse.data);
        }
    };

    const thumbs = files.map((file, index) => (
        <Col xs={'4'} key={index}>
            <Row>
                <Col xs={'12'} className={'d-flex justify-content-center'}>
                    <Thumb>
                        <ThumbInner>
                            <Img src={file.path} />
                        </ThumbInner>
                    </Thumb>
                </Col>
            </Row>
        </Col>
    ));

    return (
        <Row>
            <Col>
                {
                    files && files.length > 0 ?
                        <div>
                            <h4 className={'mt-3'}>Results</h4>
                            <p>{files.length} files founded</p>
                            <ThumbsContainer>
                                {thumbs}
                            </ThumbsContainer>
                        </div> : null
                }
            </Col>
        </Row>
    );
};