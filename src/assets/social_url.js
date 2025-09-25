function facebook(txt){
  let url = String(txt);
  return ['http','face'].includes(url.slice(0,4)) ? (url.slice(0,4) === 'face' ? 'https://'+url : (url.slice(0,5) === 'https' ? url : 'https' + url.slice(4)) ) : 'https://www.facebook.com/' + url
}

function instagram(txt){
  let url = String(txt);
  return ['http','inst'].includes(url.slice(0,4)) ? (url.slice(0,4) === 'inst' ? 'https://'+url : (url.slice(0,5) === 'https' ? url : 'https' + url.slice(4)) ) : 'https://instagram.com/' + url
}
function instagramLabel(txt){
  let url = String(txt);
  return ['http','inst','www.'].includes(url.slice(0,4)) ? url.replace("https://","").replace("http://","").replace("www.","").replace("instagram.com/","") : url
}

function linkedin(txt){
  let url = String(txt);
  return ['http','www.','link'].includes(url.slice(0,4)) ? (('https://www.linkedin.com/in/') + (/[^/]*$/.exec(url)[0])) : 'https://www.linkedin.com/in/' + url
}

export { facebook,instagram,linkedin,instagramLabel }
