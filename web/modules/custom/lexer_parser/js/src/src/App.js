import React, { Component } from 'react';
import './App.css';
import Calculation from './components/Calculation';

class App extends Component {
  render() {
      return (
          <div>
            <p>Hello React.</p>
            <Calculation expression="@todo" result="@todo" />
          </div>
      );
  }
}
export default App;
