import React, { Component } from 'react';
import './App.css';
import api from './utils/api.js';
import Calculation from './components/Calculation';

class App extends Component {
  render() {
      return (
          <div>
            <Calculation
                expression={api.getDataAttributeValue('expression')}
                result={api.getDataAttributeValue('result')}
                steps={'{}'}
            />
          </div>
      );
  }
}
export default App;
