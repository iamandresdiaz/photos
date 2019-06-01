import React from 'react';
import ReactDom from 'react-dom';
import { BrowserRouter, Route } from 'react-router-dom';
import { Overview } from "./views/Dashboard/Overview";
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import './app.css';

function App(){
    return (
        <BrowserRouter>
            <Route exact path={'/'} component={ Overview } />
        </BrowserRouter>
    );
}

const rootElement = document.getElementById('root');
ReactDom.render(<App />, rootElement);
