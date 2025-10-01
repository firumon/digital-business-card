import {useLayout} from "src/composables/layout.js";
import {useCompany} from "src/composables/company.js";
import {ref} from "vue";
import {getCssVar,colors} from "quasar";

const { hexToRgb,getPaletteColor } = colors

function luminance(hex) {
  let {r,g,b} = hexToRgb(hex)
  const a = [r, g, b].map((v) => {
    v /= 255
    return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4)
  })
  return a[0] * 0.2126 + a[1] * 0.7152 + a[2] * 0.0722
}
function getContrastRatio(bgColor,frColor){
  const lum1 = luminance(bgColor)
  const lum2 = luminance(frColor)
  const brightest = Math.max(lum1, lum2)
  const darkest = Math.min(lum1, lum2)
  return (brightest + 0.05) / (darkest + 0.05)
}

function fontColorForBG(paletteNameOfBgColor){
  const whiteRatio = getContrastRatio(getPaletteColor(paletteNameOfBgColor), '#FFFFFF')
  const blackRatio = getContrastRatio(getPaletteColor(paletteNameOfBgColor), '#000000')
  return whiteRatio > blackRatio ? '#FFFFFF' : '#000000'
}

const colorKeys = ['brand_primary','brand_secondary','color_primary','color_secondary']
const colorVals = [getCssVar('primary'),getCssVar('secondary'),fontColorForBG('white'),fontColorForBG('secondary')]

export function useColor(){
  const _layout = useLayout(), _company = useCompany()
  const returnObj = {
    brand_primary: ref(null),
    brand_secondary: ref(null),
    color_primary: ref(null),
    color_secondary: ref(null)
  }
  colorKeys.forEach(function(cKey,idx){
    if(_company[cKey]) returnObj[cKey].value = _company[cKey]
    else if(_layout[cKey]) returnObj[cKey].value = _layout[cKey]
    else returnObj[cKey].value = colorVals[idx]
  })
  return returnObj;
}
