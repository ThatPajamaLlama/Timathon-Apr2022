// Dynamic canvas sizing solution to rectify blurry canvas

const myCanvas = document.querySelector('#board canvas');
const originalHeight = myCanvas.height;
const originalWidth = myCanvas.width;
var ctx = render();

function render() {
  let dimensions = getObjectFitSize(
    true,
    myCanvas.clientWidth,
    myCanvas.clientHeight,
    myCanvas.width,
    myCanvas.height
  );
  const dpr = window.devicePixelRatio || 1;
  myCanvas.width = dimensions.width * dpr;
  myCanvas.height = dimensions.height * dpr;

  let ctx = myCanvas.getContext("2d");
  let ratio = Math.min(
    myCanvas.clientWidth / originalWidth,
    myCanvas.clientHeight / originalHeight
  );

  return ctx;
}

// adapted from: https://www.npmjs.com/package/intrinsic-scale
function getObjectFitSize(
  contains /* true = contain, false = cover */,
  containerWidth,
  containerHeight,
  width,
  height
) {
  var doRatio = width / height;
  var cRatio = containerWidth / containerHeight;
  var targetWidth = 0;
  var targetHeight = 0;
  var test = contains ? doRatio > cRatio : doRatio < cRatio;

  if (test) {
    targetWidth = containerWidth;
    targetHeight = targetWidth / doRatio;
  } else {
    targetHeight = containerHeight;
    targetWidth = targetHeight * doRatio;
  }

  return {
    width: targetWidth,
    height: targetHeight,
    x: (containerWidth - targetWidth) / 2,
    y: (containerHeight - targetHeight) / 2
  };
}

// Credit: https://codepen.io/DoomGoober/pen/BaNMQXW