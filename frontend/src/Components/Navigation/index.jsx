import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Icon from '@material-ui/core/Icon';
import { MenuList } from './styles';

export default class Navigation extends Component {
  render() {
    return (
      <MenuList>
        {this.props.menuArray.map(item => (
          <li key={item.id}>
            <Link to={item.url}>
              <Icon>{item.icon}</Icon>
              <label>{item.name}</label>
            </Link>
          </li>
        ))}
      </MenuList>
    );
  }
}
