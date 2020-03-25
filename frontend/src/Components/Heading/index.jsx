import React, { Component } from 'react';
import { HeadingContainer } from './styles';
import Filter from '../../Components/Filter';

export default class Heading extends Component {
  render() {
    return (
      <HeadingContainer>
        <h1>{this.props.title}</h1>
        <Filter />
      </HeadingContainer>
    );
  }
}
