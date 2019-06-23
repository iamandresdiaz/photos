import React from 'react';
import { Row, Col } from "reactstrap";
import styled from "@emotion/styled";

const Alert = styled.div`
    margin-top: 20px;
`;

export const AlertComponent = ({status}) => {
    return (
        <Row>
            <Col>
                {
                    status.success ?
                        <Alert className="alert alert-success" role="alert">
                            Files were saved and transformed correctly 🎉
                        </Alert> : null 
                }

                {
                    status.error ?
                        <Alert className="alert alert-warning" role="alert">
                            Files are too large.️ Try again
                        </Alert> : null
                }

            </Col>
        </Row>
    );
};
