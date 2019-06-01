import React, { Component } from 'react';
import ReactDom from 'react-dom';
import { BrowserRouter } from 'react-router-dom';
import Routes from './config/Routes';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import './app.css';

class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <Routes/>
            </BrowserRouter>
        )
    }
}

ReactDom.render(<App />, document.getElementById('root'));
