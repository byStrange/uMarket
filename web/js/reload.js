function reloadScript(url, callback) {
  // Find existing script with the same URL
  var existingScript = document.querySelector(`script[src="${url}"]`);

  // Remove the existing script if it exists
  if (existingScript) {
    existingScript.parentNode.removeChild(existingScript);
  }

  // Create a new script element
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = url + '?v=' + new Date().getTime(); // Cache-busting parameter

  // Execute the callback function after the script has been loaded
  script.onload = callback;

  // Append the new script to the head
  document.head.appendChild(script);
}
