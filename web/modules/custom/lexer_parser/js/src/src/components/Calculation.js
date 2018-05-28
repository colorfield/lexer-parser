import React from 'react';
import PropTypes from 'prop-types';
import s from './Calculation.css';

class Calculation extends React.Component {
  constructor() {
    super();
    // @todo states
  }

  static propTypes = {
    expression: PropTypes.string.isRequired,
    result: PropTypes.string.isRequired,
  };

  componentDidMount() {
    // Start animation interval
  }

  componentWillUmount() {
   // Stop animation interval
  }

  render() {
    const { expression, result } = this.props;

    return (
      <div className={s.root}>
        <div className={s.container}>
          <p>Expression: {expression}</p>
          <p>Result: {result}</p>
        </div>
      </div>
    );
  }
}

export default Calculation;
