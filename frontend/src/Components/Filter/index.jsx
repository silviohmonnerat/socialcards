import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Icon from '@material-ui/core/Icon';
import { FilterContainer } from './styles';

export default class Filter extends Component {
  state = {
    isOpenModal: false
  };

  hanldeSearch = () => {
    console.log('pesquisar...');
  };

  render() {
    return (
      <FilterContainer>
        <Link to={''} onClick={this.hanldeSearch}>
          <Icon>search</Icon>
        </Link>
      </FilterContainer>
    );
  }
}
