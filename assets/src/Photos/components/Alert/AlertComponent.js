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
                        <Alert className="alert alert-danger" role="alert">
                            💀 There is something unexpected.️ Try again.
                        </Alert> : null
                }

                {
                    status.loading ?
                        <Alert className="alert alert-info" role="alert">
                            ⏳ Uploading & transforming files...
                        </Alert> : null
                }

            </Col>
        </Row>
    );
};
