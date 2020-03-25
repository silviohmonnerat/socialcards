import styled from 'styled-components';
import fbReacoes from '../../Assets/fb-reactions.png';

export const CardContainer = styled.div`
  position: relative;
  background-color: #242635;
  text-align: center;
  border-radius: 20px;
  border-top-width: 10px;
  border-top-style: solid;
  margin-bottom: 30px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  flex-basis: 23%;

  .Card-wrapper {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
`;

export const CardHeader = styled.header`
  width: 100%;
  padding: 15px;
  box-sizing: border-box;
  justify-content: center;
  align-items: center;
  display: flex;
  flex: 3;

  .Card-header__Wrapper {
    width: 100%;
    display: flex;
    justify-content: space-between;
    box-sizing: border-box;
  }

  .Card-header__Category {
    color: #ff8d55;
  }

  .Card-header__Action {
  }

  .Card-header__Action button {
    text-transform: uppercase;
    margin: 0;
    cursor: pointer;

    border-radius: 11px;
    color: #fff;
    font-size: 8px;
    font-weight: 600;
    padding: 5px 7px;
    background-color: #242635;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    text-decoration: none;
  }
`;

export const CardBody = styled.div`
  position: relative;
  justify-content: center;
  align-items: center;
  display: flex;
  flex: 7;

  .Card--thumbnail img {
    width: 100%;
    height: 160px;
    object-fit: contain;
    object-position: center;
  }

  .Card--name {
    position: absolute;
    bottom: 7px;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    color: var(--color-white);
    font-size: 16px;
    padding: 3px 40px;
    margin: 0;
  }
`;

export const CardFooter = styled.footer`
  width: 100%;
  padding: 15px;
  justify-content: space-between;
  align-items: center;
  display: flex;
  flex: 2;
  box-sizing: border-box;

  button {
    border: 0;
    background-color: transparent;
    outline: none;
    cursor: pointer;
    text-decoration: none;
    -webkit-transition: transform 0.5s ease;
    -moz-transition: transform 0.5s ease;
    -ms-transition: transform 0.5s ease;
    transition: transform 0.5s ease;
    text-align: center;
  }

  button i {
    background-image: url(${fbReacoes});
    background-size: cover;
    background-repeat: no-repeat;
    width: 20px;
    height: 20px;
    display: block;
    margin: 0 auto;
    transition: transform 0.5s ease;
  }
  button i.like {
    background-position: 0 0;
  }
  button i.love {
    background-position: -25px 0;
  }
  button i.haha {
    background-position: -51px 0;
  }
  button i.wow {
    background-position: -76px 0;
  }
  button i.sad {
    background-position: -101px 0;
  }
  button i.angry {
    background-position: -126px 0;
  }
  button:hover i {
    transform: translateY(-0.3em);
  }

  button span {
    color: var(--color-white);
    font-size: 13;
  }
`;
