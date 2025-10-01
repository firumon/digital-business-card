import vCardsLib from "vcards-js"
import {openURL} from "quasar";

function e(value) {
  if (value) {
    if (typeof(value) !== 'string') { value = '' + value; }
    return value.replace(/\n/g, '\\n').replace(/,/g, '\\,').replace(/;/g, '\\;');
  }
  return '';
}
function nl() { return '\r\n'; }

const ext_mimeTypes = { jpg:'image/jpeg',jpeg:'image/jpeg',png:'image/png',gif:'image/gif' }
const direct = [ 'TITLE','ANNIVERSARY','UID','GENDER','NICKNAME','ROLE','URL','NOTE','SOURCE' ]
const propModified = { EMAIL:'workEmail' }

class vCardsJs {

  constructor(properties,values,individual_name,company_name) {
    this.vCards = vCardsLib();
    this.socialUrls = {};
    this.customProps = [];
    this.individual_name = individual_name
    this.prepare(properties,values,individual_name,company_name)
  }

  prepare(properties,values,individual_name,company_name){
    this.setFromFullName(individual_name)
    this.setCompanyName(company_name)
    for (const prop of properties) {
      let { params: {TYPE:type},item:property,name } = prop, value = values[name]
      let types = (type || '').split(",").filter(typ => typ)
      if(direct.includes(property)) this.vCards[property.toLowerCase()] = value;
      else if (propModified.hasOwnProperty(property)) this.vCards[propModified[property]] = value
      else if (this.propVCardFn.hasOwnProperty(property)) this.propVCardFn[property](value,types,prop)
      else this.addCustomProperty(property,value,types)
    }
  }

  setFromFullName(fullName){
    let nameParts = this.getNameParts(fullName)
    for (const nameKey in nameParts) {
      this.vCards[nameKey] = nameParts[nameKey]
    }
  }
  getNameParts(name){
    let nameSplits = String(name).trim().split(/\s+/);
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

  setCompanyName(name){
    if(!String(name).trim()) return null;
    this.vCards.organization = String(name).trim();
  }


  addSocialProfile(types, url) {
    let type = types[0];
    this.socialUrls[type.toLowerCase()] = url;
  }

  addCustomProperty(property, value, types = [], typeName = 'TYPE') {
    let line = property; if(!Array.isArray(types)) types = [types].filter(type => type)
    if(types.includes('whatsapp')) this.addSocialProfile('whatsapp','https://wa.me/' + String(value).replace('+',''))
    if (types.length > 0) {
      line += `;${typeName}=${types.join(',')}`;
    }
    line += `:${e(value)}`;
    this.customProps.push(line);
  }

  getFormattedString() {
    let formatted = this.vCards.getFormattedString();

    let injected = '';

    for (let type in this.socialUrls) {
      if (this.socialUrls.hasOwnProperty(type)) {
        const url = this.socialUrls[type];
        injected += `X-SOCIALPROFILE;TYPE=${type}:${url}` + nl();
      }
      if (this.socialUrls.hasOwnProperty(type)) {
        const url = this.socialUrls[type];
        injected += `URL;TYPE=${type}:${url}` + nl();
      }
    }

    if (this.customProps.length > 0) {
      injected += this.customProps.join('\n') + '\n';
    }

    formatted = formatted.replace('END:VCARD', injected + 'END:VCARD');
    return formatted;
  }

  embedPhoto(url){
    this.addCustomProperty('PHOTO',url,['uri'],'VALUE')
/*
    let ext = String(/[^.]*$/.exec(url)[0]).toLowerCase()//JPEG, PNG, GIF
    let mediaType = ext_mimeTypes.hasOwnProperty(ext) ? ext_mimeTypes[ext] : 'image/jpeg';
    this.vCards.photo.attachFromUrl(String(url).trim(),mediaType)
*/
  }
  embedLogo(url){
    this.addCustomProperty('LOGO',url,['uri'],'VALUE')
/*
    let ext = String(/[^.]*$/.exec(url)[0]).toLowerCase()//JPEG, PNG, GIF
    let mediaType = ext_mimeTypes.hasOwnProperty(ext) ? ext_mimeTypes[ext] : 'image/jpeg';
    this.vCards.logo.attachFromUrl(String(url).trim(),mediaType)
*/
  }

  propVCardFn = {
    PHOTO: (url) => this.embedPhoto(url),
    LOGO: (url) => this.embedLogo(url),
    'X-SOCIALPROFILE': (value,types) => this.addSocialProfile(types,value)
  }


  /**
   * Download helper for browser
   */
  download() {
    const blob = new Blob([this.getFormattedString()], { type: 'text/vcard;charset=utf-8' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = this.individual_name + '.vcf';
    link.click();
    URL.revokeObjectURL(link.href);
  }

  save(){
    openURL("data:text/vcard;charset=utf-8," + encodeURI(this.getFormattedString()));
  }
}

export default vCardsJs;
