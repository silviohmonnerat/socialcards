import React, { Component } from 'react';
import { CardContainer, CardHeader, CardBody, CardFooter } from './styles';

export default class Card extends Component {
  constructor(props) {
    super(props);

    this.state = {
      justClicked: null
    };

    this.handleClickLikes = this.handleClickLikes.bind(this);
    this.handleClickShare = this.handleClickShare.bind(this);
  }

  handleClickLikes = event => {
    this.setState({
      justClicked: event.target.dataset.value
    });
  };

  handleClickShare = event => {
    this.setState({
      justClicked: event.target.dataset.value
    });
  };

  render() {
    const { card } = this.props;

    return (
      <CardContainer className="Card">
        <div className="Card-wrapper">
          <CardHeader className="Card-header">
            <div className="Card-header__Wrapper">
              <div className="Card-header__Category">{card.categoria}</div>
              <div className="Card-header__Action">
                <button
                  className=""
                  data-value={card.name}
                  data-sequencial={card.sequencial_card}
                  data-titulo={card.titulo}
                  data-categoria={card.categoria}
                  data-cat="1"
                  onClick={this.handleClickShare}
                >
                  Compartilhar
                </button>
              </div>
            </div>
          </CardHeader>
          <CardBody>
            <div className="Card--thumbnail">
              <img
                src={require(`../../Assets/cards/${card.slug}/${
                  card.sequencial_card
                }.jpg`)}
                alt=""
              />
              <h4 className="Card--name">{card.titulo}</h4>
            </div>
          </CardBody>
          <CardFooter>
            {card.reacoes.map(item => (
              <button
                key={item.name}
                data-value={item.name}
                data-sequencial={card.sequencial_card}
                data-titulo={card.titulo}
                data-categoria={card.categoria}
                data-cat="1"
                onClick={this.handleClickLikes}
              >
                <i className={item.name} />
                <span>{item.value}</span>
              </button>
            ))}
          </CardFooter>
        </div>
      </CardContainer>
    );
  }
}
