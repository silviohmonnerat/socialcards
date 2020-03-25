import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import CircularProgress from '@material-ui/core/CircularProgress';
import { LoadingContainer } from './styles';

const styles = theme => ({
  progress: {
    margin: theme.spacing.unit * 2,
    color: '#ff8d55'
  }
});

function Loading(props) {
  const { classes } = props;
  return (
    <LoadingContainer>
      <CircularProgress className={classes.progress} />
    </LoadingContainer>
  );
}

Loading.propTypes = {
  classes: PropTypes.object.isRequired
};

export default withStyles(styles)(Loading);
