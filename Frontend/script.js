window.onload = function() {
  const pattern = trianglify({
    width: window.innerWidth,
    height: document.body.scrollHeight,
    cellSize: 80,
    xColors: ['#259ad5', '#7928ca', '#ff0080'],
  });

  document.body.style.backgroundImage = `
    linear-gradient(rgba(255,255,255,0.3), rgba(255,255,255,0.4)),
    url('data:image/svg+xml;utf8,${encodeURIComponent(pattern.toSVG().outerHTML)}')
  `;
  document.body.style.backgroundSize = 'cover';
  document.body.style.backgroundAttachment = 'fixed';
};
