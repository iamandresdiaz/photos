import React from 'react';
import { DropzoneComponent } from '../../components/Dropzone/DropzoneComponent';
import { Container, Row } from "reactstrap";
import styled from "@emotion/styled";

const Card = styled.div`
    background-color: #fff;
    padding: 40px;
    margin: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.2); 
`;

export const Photos = () => {
    return(
        <Container>
            <Row>
                <Card className={"col-12"}>
                    <DropzoneComponent />
                </Card>
            </Row>
        </Container>
    );
};