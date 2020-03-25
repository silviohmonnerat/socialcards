import styled from 'styled-components';

export const LogoContainer = styled.div`
  color: var(--color-logo);
  font-family: 'Josefin Sans', 'Roboto', sans-serif;
  font-size: 3.5rem;
  font-weight: bold;
  text-align: center;
  letter-spacing: -6px;
  text-shadow: 0 0.2rem 0.4rem hsla(240, 3%, 19%, 1),
    0 0.2rem 0.4rem hsla(240, 3%, 19%, 1);

  img {
    width: 160px;
    height: auto;
    object-fit: contain;
    object-position: center;
  }
`;
