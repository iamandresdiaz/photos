import React, { Component } from 'react';
import styled from '@emotion/styled';
import { Col, Form, FormGroup, Label, Input } from "reactstrap";


const FormSection = styled.div`
    background-color: #fff;
    padding: 40px;
`;

class DropzoneComponent extends Component {
    constructor(props){
        super(props);

        this.state = {
            text: ''
        };

        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
    }

    handleInputChange(e){
        const { name, value } = e.target;
        this.setState({ [name]: value });
    }

    handleSubmit(e){
        e.preventDefault();

        const { text } = this.state;

        console.log(text);
    }

    render() {
        const { text } = this.state;
        return(
            <FormSection className={"col-5"}>
                <Form id="dropzone" onSubmit={this.handleSubmit}>
                    <Col>
                        <FormGroup>
                            <Label for="input">Email</Label>
                            <Input
                                onChange={this.handleInputChange}
                                value={text}
                                type="text"
                                className={"form-control"}
                                name="input"
                                id="input"
                                placeholder="Type something"
                                autoComplete="on"
                            />
                        </FormGroup>
                    </Col>
                    <Col className={"mt-5"}>
                        <input className={"btn btn-dark"} type="submit" value="Upload"/>
                    </Col>
                </Form>
            </FormSection>
        );
    }
}

export default DropzoneComponent;