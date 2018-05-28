import React from 'react';
import PropTypes from 'prop-types';
import s from './Calculation.css';

class Calculation extends React.Component {
  static propTypes = {
    expression: PropTypes.string.isRequired,
    result: PropTypes.string.isRequired,
    // steps: PropTypes.shape({
    //   value: PropTypes.string.isRequired,
    //   operator: PropTypes.string.isRequired,
    // }).isRequired,
  };

  componentDidMount() {
    // Start animation interval
  }

  componentWillUmount() {
   // Stop animation interval
  }

  render() {
    // @todo add steps
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
