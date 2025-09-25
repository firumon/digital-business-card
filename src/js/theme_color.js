import {forEach, get} from "lodash";
import {setCssVar} from "quasar";

function init_theme(_theme){
  let colorTxtNodes = [];
  forEach(_theme.brand,function(color,name){
    if(color) setCssVar(name,color);
    let tColor = get(_theme,['color',name]);
    if(tColor) colorTxtNodes.push('.bg-' + name + ' { color: '+ tColor +' }')
  })
  if(colorTxtNodes.length){
    let styleDom = document.createElement('style'); styleDom.type = 'text/css';
    if(styleDom.styleSheet) styleDom.styleSheet.cssText = colorTxtNodes.join("\n");
    else styleDom.appendChild(document.createTextNode(colorTxtNodes.join("\n")))
    document.getElementsByTagName('head')[0].appendChild(styleDom);
  }
}

export default init_theme
