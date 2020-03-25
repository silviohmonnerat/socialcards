import React from 'react';
import { Switch, Route } from 'react-router-dom';

import Home from './Pages/Home';
import About from './Pages/About';

export const Routes = () => (
  <Switch>
    <Route exact path="/" component={Home} />
    <Route path="/sobre" component={About} />
  </Switch>
);
