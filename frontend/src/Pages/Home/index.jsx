import React, { Component } from 'react';
import Heading from '../../Components/Heading';
import Api from '../../Services/Api';
import Loading from '../../Components/Loading';
import Card from '../../Components/Card';

export default class Home extends Component {
  constructor() {
    super();

    this.state = {
      title: 'Home',
      isLoading: false,
      cards: []
    };
  }

  async componentDidMount() {
    document.title = 'Início - Social Cards';
    this.setState({ isLoading: true });

    const response = await Api.get('cardslist');

    this.setState({
      cards: response.data.data,
      isLoading: false
    });
  }

  render() {
    const { isLoading } = this.state;

    if (isLoading) {
      return (
        <div className="App-Content__home">
          <Loading />
        </div>
      );
    }

    return (
      <div className="App-Content__home">
        <Heading title={this.state.title} />

        <div className="App-Content__cards">
          {this.state.cards.map(items => (
            <Card key={items.sequencial_card} card={items} />
          ))}
        </div>
      </div>
    );
  }
}
