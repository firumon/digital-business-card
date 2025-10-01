import vCardsJS from "./vCardsJs.js"
import {map} from "lodash";
import * as SocialUrl from "assets/social_url.js";

const ignore = ['code']
const ext_mimeTypes = { jpg:'image/jpeg',jpeg:'image/jpeg',png:'image/png',gif:'image/gif' }
const fns = {
  name,whatsapp
}
const attr = {
  designation:'title',
  email_address:'email',
  email:'email',
  work_email_address:'workEmail',
  work_email:'workEmail',
  mobile_number:'cellPhone',
  office_number:'workPhone',
  website:'url'
}
const special = {
  facebook:socialUrl,
  instagram:socialUrl,
  linkedin:socialUrl,
  profile_photo
}

function generate(contacts,individual,company){
  const vCardObj = vCardsJS();
  if(company && company.name) vCardObj.organization = String(company.name).trim();
  map(individual,function(value,field){
    if(ignore.includes(field)) return null;
    if(typeof fns[field] === 'function') return map(fns[field](value,individual),(val,attr) => vCardObj[attr] = val);
    if(typeof attr[field] !== 'undefined') return vCardObj[attr[field]] = String(value).trim()
    if(typeof special[field] === 'function') return special[field](vCardObj,value,field)
  })
  return vCardObj.getFormattedString()
}

export { generate }

function name(value){
  let nameSplits = String(value).trim().split(/\s+/);
  while(nameSplits.map(nm => nm.toLowerCase()).includes('al')){
    let alIdx = nameSplits.map(nm => nm.toLowerCase()).indexOf('al');
    if(alIdx !== nameSplits.length-1){
      nameSplits[alIdx+1] = nameSplits[alIdx]+" "+nameSplits[alIdx+1];
      nameSplits.splice(alIdx,1);
    }
  }
  if(nameSplits.length === 1) return { firstName:nameSplits[0] }
  if(nameSplits.length === 2) return { firstName:nameSplits[0],lastName:nameSplits[1] }
  return { firstName:nameSplits[0],middleName:nameSplits.slice(1,-1).join(" "),lastName:nameSplits.slice(-1)[0] }
}
function whatsapp(value,individual){
  if(individual.hasOwnProperty('mobile_number')) return { cellPhone:[value,individual.mobile_number] }
  return { cellPhone:value }
}

//----------------------------------
function socialUrl(obj,value,field){
  obj.socialUrls[field] = SocialUrl[field](value)
}
function profile_photo(obj,value){
  let ext = String(/[^.]*$/.exec(value)[0]).toLowerCase()//JPEG, PNG, GIF
  let mediaType = ext_mimeTypes.hasOwnProperty(ext) ? ext_mimeTypes[ext] : 'image/jpeg';
  obj.photo.attachFromUrl(String(value).trim(),mediaType)
}
/*
*
download(filename = "contact.vcf") {
    const vcardStr = this.toString();
    const blob = new Blob([vcardStr], { type: "text/vcard;charset=utf-8" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(link.href);
  }
}
* */
