export const normalizeUrl = function(url,protocol = 'https'){
  if(url.slice(0,4) !== 'http') url = protocol + '://' + url;
  if(url.slice(-1) === '/') url = url.slice(0,-1);
  return url
}
