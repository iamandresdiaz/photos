import React, { useState } from 'react';
import { Row, Col, Form, FormGroup, Input, Label } from "reactstrap";
import { sessionActions } from "../../actions/Search/SessionActions";


export const SearchComponent = () => {

    const [searchText, setSearchText] = useState('');

    const handleInputChange = (event) => {
        setSearchText(event.target.value);
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        let json = createJsonItem(searchText);
        sessionActions.search(json);
        setSearchText('');
    };

    const createJsonItem = (text) => {
        return JSON.stringify({
            text: text,
        });

    };

    return (
        <Row>
            <Col>
                <Form onSubmit={handleSubmit} id={'searchBar'}>
                    <FormGroup className={'mb-0'}>
                        <Label for={'searchInput'}>Search</Label>
                        <Input
                            onChange={(event) => handleInputChange(event)}
                            value={searchText}
                            type={'search'}
                            id={'searchInput'}
                            placeholder={'🔍 Search for files...'}
                            autoComplete={'off'}
                            name={'search'}
                        />
                    </FormGroup>
                </Form>
            </Col>
        </Row>
    );
};