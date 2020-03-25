import Axios from 'axios';

const Api = Axios.create({
  baseURL: 'https:socialcards.com.br'
});

export default Api;
