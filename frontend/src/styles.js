import { createGlobalStyle } from 'styled-components';

import 'font-awesome/css/font-awesome.css';

const GlobalStyle = createGlobalStyle`
    :root {
        
        --primary: hsla(208, 18%, 33%, 1);
        --secondary: hsla(176, 64%, 49%, 1);
        --terciary: hsl(208, 19%, 16%);
        
        --primary-color: hsla(237, 32%, 19%, 5);
        --secondary-color: hsla(237, 32%, 9%, 4);

        --color-pink: hsla(330, 72%, 67%, 85);
        --color-purple: hsla(266, 56%, 48%, 43);
        --color-blue: hsla(217, 99%, 45%, 21);
        --color-yellow: hsla(42, 15%, 95%, 2);
        --color-white: hsla(240, 1%, 89%, 1);

        --color-logo: hsla(0, 100%, 100%, .75);

        --color-blue-primary: hsl(232, 53%, 19%);
        --color-blue-secondary: hsl(231, 58%, 12%);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        outline: 0;
    }

    body {
        background-color: #242635;
        text-rendering: optimizeLegibility !important;
        -webkit-font-smoothing: antialiased !important;
        font-family: 'Roboto', sans-serif;
        color: var(--color-white);
    }

    .App {
        width: 100%;
        height: 100%;

        display: flex;
        align-items: center;
        align-content: center;
        justify-content: center;
    }

    .App-Sidebar {
        position:fixed;
        top: 0;
        left: 0;
        width: 200px;
        height: 100vh;
        background-color: #242635;
    }

    .Sidebar {
        min-height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .Sidebar .Sidebar-Top {
        justify-content: center;
        align-items: center;
        display: flex;
        flex: 4;
    }

    .Sidebar .Sidebar-Middle {
        justify-content: center;
        align-items: center;
        display: flex;
        flex: 4;
    }

    .Sidebar-Bottom {
        justify-content: center;
        align-items: flex-end;
        display: flex;
        flex: 4;
    }

    .Sidebar-Bottom  p {
        font-family: 'Roboto', sans-serif;
        font-weight: 100;
        font-size: 11px;
        padding: 20px;
        text-align: center;
    }

    .App-Content {
        position: relative;
        width: calc(100% - 200px);
        margin-top: 50px;
        margin-left: 200px;
        min-height: calc(100vh - 50px);
        height: fit-content;
        align-self: flex-end;
        background: #1d1d29;
        border-radius: 130px 40px 0px 0px;
        padding: 60px 100px;
    }

    .App-Content__cards{
        position: relative;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        flex-flow: row wrap;
        justify-content: space-between;
        box-sizing: border-box;
    }
`;

export default GlobalStyle;
