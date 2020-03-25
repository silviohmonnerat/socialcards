import React, { Component } from 'react';

import Logo from './Components/Logo';
import Navigation from './Components/Navigation';

const menuList = [
  {
    id: 1,
    url: '/',
    name: 'Home',
    icon: 'home'
  },
  {
    id: 2,
    url: '/sobre',
    name: 'Sobre',
    icon: 'info'
  }
];

export default class Sidebar extends Component {
  render() {
    return (
      <nav className="Sidebar">
        <div className="Sidebar-Top">
          <Logo />
        </div>
        <div className="Sidebar-Middle">
          <Navigation menuArray={menuList} />
        </div>
        <div className="Sidebar-Bottom">
          <p>© 2019 - Social Cards Termos de uso e Políticas de privacidade</p>
        </div>
      </nav>
    );
  }
}
