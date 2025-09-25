import{s as d,d as f}from"./index-DpVdVZbR.js";import{l as i}from"./lodash-DjxWLlCR.js";function l(o){let t=[];if(i.forEach(o.brand,function(e,n){e&&d(n,e);let s=i.get(o,["color",n]);s&&t.push(".bg-"+n+" { color: "+s+" }")}),t.length){let e=document.createElement("style");e.type="text/css",e.styleSheet?e.styleSheet.cssText=t.join(`
`):e.appendChild(document.createTextNode(t.join(`
`))),document.getElementsByTagName("head")[0].appendChild(e)}}const r=f(async o=>{typeof __DATA<"u"&&l(__DATA.theme),typeof __COMPANY<"u"&&l(__COMPANY.layout)});export{r as default};
