import router from "./router";
import {toNumber} from "lodash";

export function redirectToLogin() {
  return router.push({
    name: 'Login',
    params: {nextUrl: router.currentRoute.value.fullPath},
  });
}

function getTillion(i: number) {
  const WW = ["M", "B", "Tr", "Quadr", "Quint", "Sext", "Sept", "Okt", "Non", "Dez", "Undez", "Duodez", "Tredez", "Quadradez", "Quintadez", "Sextadez"];
  const WWW = ["", "Un", "Duo", "Tre", "Quattuor", "Quin", "Sex", "Septen", "Okto", "Novem"];
  const WWWW = ["", "Dez", "Vigint", "Trigint", "Quadragint", "Quinquagint", "Sexagint", "Septuagint", "Oktogint", "Nonagint"];
  const WWWWW = ["", "Cent", "Ducent", "Trecent", "Quadringent", "Quingent", "Sescent", "Septingent", "Octingent", "Nongent"];
  const WWWWWW = ["", "Millia", "Domillia", "Tremillia", "Quattuormillia", "Quinmillia", "Sexmillia", "Septenmillia", "Oktomillia"];
  if (i == 0) return "";
  if (i < 10) return WW[i - 1];
  const e = i % 10, z = Math.floor(i / 10) % 10, h = Math.floor(i / 100) % 10, t = Math.floor(i / 1000) % 10,
    zt = Math.floor(i / 10000) % 10, ht = Math.floor(i / 100000) % 10;
  let a = WWW[e] + WWWW[z];
  if (i < 100) return a.charAt(0).toUpperCase() + a.substr(1, a.length).toLowerCase();
  a = WWWWW[h] + a;
  if (i < 4000) a = WWWWWW[t] + a;
  else a = WWWWW[ht] + WWW[t] + WWWW[zt] + "millia" + a;
  const aa = a.charAt(a.length - 1);
  if ((aa != "t") && (aa != "z")) a += "t";
  return a.charAt(0).toUpperCase() + a.substr(1, a.length).toLowerCase();
}

export function getZahlwort(x: string, tr: boolean = false): string {
  let xi = toNumber(x);
  if (x == "pi") return getZahlwort("3,1415926535897932384626433832795028841971693993751058209749445923078164062862089986280348253421170679821480865132823066470938446095505822317253594081284811174502841027019385211055596446229489549303819644288109756659334461284756482337867831652712019091456485669234603486104543266482133936072602491412737245870066063155881748815209209628292540917153643678925903600113305305488204665213841469519415116094330572703657595919530921861173819326117931051185480744623799627495673518857527248912279381830119491298336733624406566430860213949463952247371907021798609437027705392171762931767523846748184676694051320005681271452635608277857713427577896091736371787214684409012249534301465495853710507922796892589235420199561121290219608640344181598136297747713099605187072113499999983729780499510597317328160963185950244594553469083026425223082533446850352619311881710100031378387528865875332083814206171776691473035982534904287554687311595628638823537875937519577818577805321712268066130019278766111959092164201989") + " ...";
  if (x == "e") return getZahlwort("2,7182818284590452353602874713526624977572470936999595749669676277240766303535475945713821785251664274274663919320030599218174135966290435729003342952605956307381323286279434907632338298807531952510190115738341879307021540891499348841675092447614606680822648001684774118537423454424371075390777449920695517027618386062613313845830007520449338265602976067371132007093287091274437470472306969772093101416928368190255151086574637721112523897844250569536967707854499699679468644549059879316368892300987931277361782154249992295763514822082698951936680331825288693984964651058209392398294887933203625094431173012381970684161403970198376793206832823764648042953118023287825098194558153017567173613320698112509961818815930416903515988885193458072738667385894228792284998920868058257492796104841984443634632449684875602336248270419786232090021609902353043699418491463140934317381436405462531520961836908887070167683964243781405927145635490613031072085103837505101157477041718986106873969655212671546889570350354") + " ...";
  if ((x == "phi") || (x.indexOf("goldener Schnitt") == 0)) return getZahlwort("0,6180339887498948482045868343656381177203091798057628621354486227052604628189024497072072041893911374847540880753868917521266338622235369317931800607667263544333890865959395829056383226613199282902678806752087668925017116962070322210432162695486262963136144381497587012203408058879544547492461856953648644492410443207713449470495658467885098743394422125448770664780915884607499887124007652170575179788341662562494075890697040002812104276217711177780531531714101170466659914669798731761356006708748071013179523689427521948435305678300228785699782977834784587822891109762500302696156170025046433824377648610283831268330372429267526311653392473167111211588186385133162038400522216579128667529465490681131715993432359734949850904094762132229810172610705961164562990981629055520852479035240602017279974717534277759277862561943208275051312181562855122248093947123414517022373580577278616008688382952304592647878017889921990270776903895321968198615143780314997411069260886742962267575605231727775203536139362") + " ...";
  if (x == "Phi") return getZahlwort("phi").replace(/null K/, "eins K");
  if (x.indexOf("/") > -1) return getBruchZahlwort(x);
  if (x == "0") return "null";
  x = x.replace(/ /g, "").replace(/\./g, ",");
  const xx = x.split(",");
  if (x.replace(/\D/g, "") == "") return "";
  let t = "", v = (x.charAt(0) == "-") ? "Minus " : "", i = 0;
  x = x.replace(/-/, "").replace(/ /g, "");
  x = xx[0].replace(/\D/g, "");
  if (x.length > 999999 * 6) return "diese Zahl ist unheimlich groß, die ist mir zu unheimlich";
  const ZZ = ["null", "eins", "zwei", "drei", "vier", "fünf", "sechs", "sieben", "acht", "neun"];
  const ZZZ = ["zehn", "elf", "zwölf"];
  const ZZig = ["", "zehn", "zwanzig", "dreißig", "vierzig", "fünfzig", "sechzig", "siebzig", "achtzig", "neunzig"];
  tr = !((tr == null) || !tr || (xi < 1000000));
  const trz = (tr) ? " " : "";
  if (x == "0,0") return "Nullkommanix";
  while (x != "") {
    while (x.length < 3) x = "0" + x;
    let y = x.substr(x.length - 3, 3);
    x = x.substr(0, x.length - 3);
    while (y.length < 3) y = "0" + y;//alert(y);
    const y1 = parseInt(y.charAt(0)), y2 = parseInt(y.charAt(1)), y3 = parseInt(y.charAt(2));
    let tt = ZZ[y1] + "hundert";
    if (y2 == 1) {
      if (y3 < 3) tt += ZZZ[y3]; else tt += ZZ[y3].replace(/hs/, "h").replace(/en/, "") + "zehn";
    } else tt += ZZ[y3] + ((y2 > 1) ? "und" + ZZig[y2] : "");
    tt = tt.replace(/nullhundert/, "").replace(/eins/g, "ein").replace(/nullund/g, "").replace(/null/g, "");
    if ((tt == "ein") && (i == 0)) tt += "s";
    if (i == 0) t = "_" + tt + t;
    if ((i == 1) && (tt != "")) t = "_" + tt + "tausend" + t;
    if ((i > 1) && (tt == "ein")) {
      t = "_eine" + trz + getTillion(Math.floor(i / 2)) + (((i % 2) == 1) ? "illiarde" : "illion") + trz + t;
    } else if ((i > 1) && (tt != "")) t = "_" + tt + trz + getTillion(Math.floor(i / 2)) + (((i % 2) == 1) ? "illiarden" : "illionen") + trz + t;
    i++;
  }
  const T = t.split(" ");
  //T[0]=T[0].replace(/_/,"");
  for (i = 0; i < T.length; i++) T[i] = T[i].charAt(0).toUpperCase() + T[i].substring(1, T[i].length).toLowerCase();
  t = T.join(trz).replace(/_/g, "");
  if (!tr) t = t.toLowerCase();
  if (xx.length > 1) {
    if (t == "") t = "null";
    x = xx[1].replace(/\D/g, "");
    t += " Komma";
    for (i = 0; i < x.length; i++) t += " " + ZZ[parseInt(x.charAt(i))];
  }
  return v + t;
}

function getZehnerpotenz(n: number): string {
  n = parseInt(String(n));
  if (isNaN(n)) return "";
  if (n == 0) return "eins";
  if (n == 1) return "zehn";
  if (n == 2) return "hundert";
  if (n == 3) return "tausend";
  if (n == 4) return "zehntausend";
  if (n == 5) return "hunderttausend";
  if (n == -1) return "ein Zehntel";
  if (n == -2) return "ein Hundertstel";
  if (n == -3) return "ein Tausendstel";
  if (n == -4) return "ein Zehntausendstel";
  if (n == -5) return "ein Hunderttausendstel";
  if (n == 100) return "zehn Sexdezilliarden - oder 'ein Googol'";
  const v = (n < 0);
  n = Math.abs(n);
  var m = n % 6, p = m % 3, q = m > 2, n = (n - m) / 6;
  let t = (["eine", "zehn", "hundert"])[p] + " " + getTillion(n) + "illi" + (q ? "arde" : "on");
  if (!v) return (t + ((p > 0) ? "en" : "")).replace(/ee/, "e");
  t = t.replace(/eine/, "").replace(/ /, "").toLowerCase();
  return "ein " + (t.charAt(0).toUpperCase() + t.substr(1, t.length - 1) + "stel").replace(/estel/, "stel");
}

function getBruchZahlwort(x: string) {
  const xx = x.split("/");
  if (xx.length == 1) return getZahlwort(x);
  if ((xx[1] == "") || (String(x).replace(/\./, ",").indexOf(",") > -1)) return "";
  let Z = getZahlwort(xx[0], true), N = getZahlwort(xx[1]) + "tel";
  if (N == "nulltel") return Z + " geteilt durch Null (nicht definiert!)";
  if (Z == "eins") Z = "ein";
  N = N.replace(/ttel/, "tel").replace(/igtel/, "igstel").replace(/eine/, "");
  N = N.replace(/dreitel/, "drittel").replace(/bentel/, "btel");
  N = N.charAt(0).toUpperCase() + N.substr(1, N.length - 1);
  N = N.replace(/ionentel/, "ionstel").replace(/iardentel/, "iardstel");
  N = N.replace(/iontel/, "ionstel").replace(/iardetel/, "iardstel");
  if (N == "Zweitel") N = (Z == "ein") ? "Halb" : "Halbe";
  if (N == "Einstel") N = (Z == "ein") ? "Ganzes" : "Ganze";
  return Z + " " + N;
}
