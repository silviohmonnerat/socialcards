import React, { Component } from 'react';
import Heading from '../../Components/Heading';

import FacebookLoginButton from '../../Components/FacebookLogin';

//import { AppAbout } from './styles'

export default class About extends Component {
  constructor() {
    super();

    this.state = {
      title: 'Sobre',
      username: null
    };
  }

  componentDidMount() {
    document.title = 'Sobre - Social Cards';
  }

  onFacebookLogin = (loginStatus, resultObject) => {
    if (loginStatus === true) {
      this.setState({
        username: resultObject.user.name
      });
    } else {
      alert('Facebook login error');
    }
  };

  render() {
    const { username } = this.state;

    return (
      <div className="App">
        <Heading title={this.state.title} />

        <div className="App-intro">
          {!username && (
            <div>
              <p>Click on one of any button below to login</p>
              <FacebookLoginButton onLogin={this.onFacebookLogin}>
                <button>Facebook</button>
              </FacebookLoginButton>
            </div>
          )}
          {username && <p>Welcome back, {username}</p>}
        </div>
      </div>
    );
  }
}
