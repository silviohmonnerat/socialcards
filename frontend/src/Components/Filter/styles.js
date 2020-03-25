import styled from 'styled-components';

export const FilterContainer = styled.div`
  a {
    color: var(--color-white);
  }

  span {
    transform: scale(1);
    transition: transform 0.3s ease-in-out;
    font-size: 30px;
  }

  a:hover span {
    transform: scale(1.2);
  }
`;
