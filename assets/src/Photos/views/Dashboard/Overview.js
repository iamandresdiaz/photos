import React from 'react';
import { DropzoneComponent } from '../../components/Dropzone/DropzoneComponent';
import { Container, Row, Col } from "reactstrap";

export const Overview = () => {
    return(
        <Container>
            <Row>
                <Col xs="12" className={"d-flex justify-content-center"}>
                    <DropzoneComponent />
                </Col>
            </Row>
        </Container>
    );
};