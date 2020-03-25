import React, { Component } from 'react';
import { BrowserRouter } from 'react-router-dom';

import GlobalStyle from './styles';

import { Routes } from './Routes';
import Sidebar from './Sidebar';

export default class App extends Component {
  render() {
    return (
      <BrowserRouter>
        <div className="App">
          <GlobalStyle />
          <div className="App-Sidebar">
            <Sidebar />
          </div>
          <div className="App-Content">
            <Routes />
          </div>
        </div>
      </BrowserRouter>
    );
  }
}
