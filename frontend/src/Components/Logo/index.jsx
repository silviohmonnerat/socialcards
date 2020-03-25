import React, { Component } from 'react';
import LogoOrange from '../../Assets/social-card-logo-orange.png';
import { LogoContainer } from './styles';

export default class Logo extends Component {
  render() {
    return (
      <LogoContainer>
        <img src={LogoOrange} alt="" />
      </LogoContainer>
    );
  }
}
