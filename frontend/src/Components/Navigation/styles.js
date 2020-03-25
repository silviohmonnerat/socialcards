import styled from 'styled-components';

export const MenuList = styled.ul`
  list-style-type: none;
  padding: 2rem 0 0;
  margin: 0;
  justify-content: center;
  align-items: center;

  li {
    padding-top: 2rem;
    cursor: pointer;
    text-align: center;
    transition: all 0.3s ease;
  }

  li:first-of-type {
    padding-top: 0;
  }

  li a {
    position: relative;
    font-size: 10px;
    opacity: 0.5;
    text-decoration: none;
    transition: transform 0.15s ease;
    transition: all 0.3s ease;
  }

  li a label {
    display: block;
    flex-basis: 100%;
    padding-top: 0.25rem;
    transform: translateX(-200px);
    transition: all 0.15s ease;
    color: var(--color-pink);
    text-transform: uppercase;
  }

  li a .material-icons {
    font-size: 35px;
    color: var(--color-white);
  }

  li a:hover,
  li a:active {
    opacity: 1;
  }

  li a:hover label,
  li a:active label {
    transform: translateX(0);
    color: #ff8d55;
    font-weight: bold;
    font-size: 14px;
  }

  li a:hover .material-icons,
  li a:active .material-icons {
    transform: scale(1.1);
    animation: dash 12s ease alternate;
  }

  @media screen and (max-width: $media768) {
    li label {
      transform: translateY(-200px);
      align-self: flex-end;
      padding-bottom: 0.5rem;
    }
  }

  @keyframes dash {
    from {
      stroke-dashoffset: 1000;
    }
    to {
      stroke-dashoffset: 0;
    }
  }
`;
