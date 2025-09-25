import { defineBoot } from '#q-app/wrappers'
import init_theme from "src/js/theme_color.js";

export default defineBoot(async (ctx) => {
  if(typeof __DATA !== "undefined") init_theme(__DATA.theme)
  if(typeof __COMPANY !== "undefined") init_theme(__COMPANY.layout)
})
