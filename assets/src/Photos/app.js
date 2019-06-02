import React from 'react';
import ReactDom from 'react-dom';
import { BrowserRouter, Route } from 'react-router-dom';
import { Photos } from "./views/Dashboard/Photos";
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import './app.css';

function App(){
    return (
        <BrowserRouter>
            <Route exact path={'/'} component={ Photos } />
        </BrowserRouter>
    );
}

const rootElement = document.getElementById('root');
ReactDom.render(<App />, rootElement);
