import React, { Component } from 'react';
import { Route, Switch, withRouter } from 'react-router-dom';
import Overview from '../views/Dashboard/Overview';

class Routes extends Component {

    render() {
        return (
            <Switch>
                <Route exact path={'/'} render={ () => <Overview />} />
            </Switch>
        )
    }
}

export default withRouter(Routes);