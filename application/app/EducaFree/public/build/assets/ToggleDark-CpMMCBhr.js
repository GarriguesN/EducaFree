import{i as X,r as M,u as j,V as Y,W as z,H as U,o as J,G as H,X as Z,Y as ee,I as P,M as R,P as D,y as te,C as ne,b as re,c as oe,t as ae}from"./app-BCejmdRG.js";function B(e){return Z()?(ee(e),!0):!1}function _(e){return typeof e=="function"?e():j(e)}const se=typeof window<"u"&&typeof document<"u";typeof WorkerGlobalScope<"u"&&globalThis instanceof WorkerGlobalScope;const ie=Object.prototype.toString,ue=e=>ie.call(e)==="[object Object]",G=()=>{};function le(e,t){function n(...a){return new Promise((r,s)=>{Promise.resolve(e(()=>t.apply(this,a),{fn:t,thisArg:this,args:a})).then(r).catch(s)})}return n}const I=e=>e();function ce(e=I){const t=M(!0);function n(){t.value=!1}function a(){t.value=!0}const r=(...s)=>{t.value&&e(...s)};return{isActive:z(t),pause:n,resume:a,eventFilter:r}}function fe(e){return P()}function de(...e){if(e.length!==1)return Y(...e);const t=e[0];return typeof t=="function"?z(U(()=>({get:t,set:G}))):M(t)}function pe(e,t,n={}){const{eventFilter:a=I,...r}=n;return R(e,le(a,t),r)}function ge(e,t,n={}){const{eventFilter:a,...r}=n,{eventFilter:s,pause:u,resume:i,isActive:l}=ce(a);return{stop:pe(e,t,{...r,eventFilter:s}),pause:u,resume:i,isActive:l}}function K(e,t=!0,n){fe()?J(e,n):t?e():H(e)}function me(e=!1,t={}){const{truthyValue:n=!0,falsyValue:a=!1}=t,r=X(e),s=M(e);function u(i){if(arguments.length)return s.value=i,s.value;{const l=_(n);return s.value=s.value===l?_(a):l,s.value}}return r?u:[s,u]}function $(e){var t;const n=_(e);return(t=n==null?void 0:n.$el)!=null?t:n}const E=se?window:void 0;function V(...e){let t,n,a,r;if(typeof e[0]=="string"||Array.isArray(e[0])?([n,a,r]=e,t=E):[t,n,a,r]=e,!t)return G;Array.isArray(n)||(n=[n]),Array.isArray(a)||(a=[a]);const s=[],u=()=>{s.forEach(g=>g()),s.length=0},i=(g,c,b,h)=>(g.addEventListener(c,b,h),()=>g.removeEventListener(c,b,h)),l=R(()=>[$(t),_(r)],([g,c])=>{if(u(),!g)return;const b=ue(c)?{...c}:c;s.push(...n.flatMap(h=>a.map(v=>i(g,h,v,b))))},{immediate:!0,flush:"post"}),p=()=>{l(),u()};return B(p),p}function he(){const e=M(!1),t=P();return t&&J(()=>{e.value=!0},t),e}function ve(e){const t=he();return D(()=>(t.value,!!e()))}function ye(e,t={}){const{window:n=E}=t,a=ve(()=>n&&"matchMedia"in n&&typeof n.matchMedia=="function");let r;const s=M(!1),u=p=>{s.value=p.matches},i=()=>{r&&("removeEventListener"in r?r.removeEventListener("change",u):r.removeListener(u))},l=te(()=>{a.value&&(i(),r=n.matchMedia(_(e)),"addEventListener"in r?r.addEventListener("change",u):r.addListener(u),s.value=r.matches)});return B(()=>{l(),i(),r=void 0}),s}const F=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{},W="__vueuse_ssr_handlers__",we=be();function be(){return W in F||(F[W]=F[W]||{}),F[W]}function Q(e,t){return we[e]||t}function Se(e){return e==null?"any":e instanceof Set?"set":e instanceof Map?"map":e instanceof Date?"date":typeof e=="boolean"?"boolean":typeof e=="string"?"string":typeof e=="object"?"object":Number.isNaN(e)?"any":"number"}const ke={boolean:{read:e=>e==="true",write:e=>String(e)},object:{read:e=>JSON.parse(e),write:e=>JSON.stringify(e)},number:{read:e=>Number.parseFloat(e),write:e=>String(e)},any:{read:e=>e,write:e=>String(e)},string:{read:e=>e,write:e=>String(e)},map:{read:e=>new Map(JSON.parse(e)),write:e=>JSON.stringify(Array.from(e.entries()))},set:{read:e=>new Set(JSON.parse(e)),write:e=>JSON.stringify(Array.from(e))},date:{read:e=>new Date(e),write:e=>e.toISOString()}},x="vueuse-storage";function Ce(e,t,n,a={}){var r;const{flush:s="pre",deep:u=!0,listenToStorageChanges:i=!0,writeDefaults:l=!0,mergeDefaults:p=!1,shallow:g,window:c=E,eventFilter:b,onError:h=o=>{console.error(o)},initOnMounted:v}=a,m=(g?ne:M)(typeof t=="function"?t():t);if(!n)try{n=Q("getDefaultStorage",()=>{var o;return(o=E)==null?void 0:o.localStorage})()}catch(o){h(o)}if(!n)return m;const w=_(t),O=Se(w),S=(r=a.serializer)!=null?r:ke[O],{pause:L,resume:f}=ge(m,()=>T(m.value),{flush:s,deep:u,eventFilter:b});c&&i&&K(()=>{V(c,"storage",y),V(c,x,N),v&&y()}),v||y();function k(o,d){c&&c.dispatchEvent(new CustomEvent(x,{detail:{key:e,oldValue:o,newValue:d,storageArea:n}}))}function T(o){try{const d=n.getItem(e);if(o==null)k(d,null),n.removeItem(e);else{const C=S.write(o);d!==C&&(n.setItem(e,C),k(d,C))}}catch(d){h(d)}}function A(o){const d=o?o.newValue:n.getItem(e);if(d==null)return l&&w!=null&&n.setItem(e,S.write(w)),w;if(!o&&p){const C=S.read(d);return typeof p=="function"?p(C,w):O==="object"&&!Array.isArray(C)?{...w,...C}:C}else return typeof d!="string"?d:S.read(d)}function y(o){if(!(o&&o.storageArea!==n)){if(o&&o.key==null){m.value=w;return}if(!(o&&o.key!==e)){L();try{(o==null?void 0:o.newValue)!==S.write(m.value)&&(m.value=A(o))}catch(d){h(d)}finally{o?H(f):f()}}}}function N(o){y(o.detail)}return m}function q(e){return ye("(prefers-color-scheme: dark)",e)}function Ae(e={}){const{selector:t="html",attribute:n="class",initialValue:a="auto",window:r=E,storage:s,storageKey:u="vueuse-color-scheme",listenToStorageChanges:i=!0,storageRef:l,emitAuto:p,disableTransition:g=!0}=e,c={auto:"",light:"light",dark:"dark",...e.modes||{}},b=q({window:r}),h=D(()=>b.value?"dark":"light"),v=l||(u==null?de(a):Ce(u,a,s,{window:r,listenToStorageChanges:i})),m=D(()=>v.value==="auto"?h.value:v.value),w=Q("updateHTMLAttrs",(f,k,T)=>{const A=typeof f=="string"?r==null?void 0:r.document.querySelector(f):$(f);if(!A)return;let y;if(g&&(y=r.document.createElement("style"),y.appendChild(document.createTextNode("*,*::before,*::after{-webkit-transition:none!important;-moz-transition:none!important;-o-transition:none!important;-ms-transition:none!important;transition:none!important}")),r.document.head.appendChild(y)),k==="class"){const N=T.split(/\s/g);Object.values(c).flatMap(o=>(o||"").split(/\s/g)).filter(Boolean).forEach(o=>{N.includes(o)?A.classList.add(o):A.classList.remove(o)})}else A.setAttribute(k,T);g&&(r.getComputedStyle(y).opacity,document.head.removeChild(y))});function O(f){var k;w(t,n,(k=c[f])!=null?k:f)}function S(f){e.onChanged?e.onChanged(f,O):O(f)}R(m,S,{flush:"post",immediate:!0}),K(()=>S(m.value));const L=D({get(){return p?v.value:m.value},set(f){v.value=f}});try{return Object.assign(L,{store:v,system:h,state:m})}catch{return L}}function De(e={}){const{valueDark:t="dark",valueLight:n="",window:a=E}=e,r=Ae({...e,onChanged:(i,l)=>{var p;e.onChanged?(p=e.onChanged)==null||p.call(e,i==="dark",l,i):l(i)},modes:{dark:t,light:n}}),s=D(()=>r.system?r.system.value:q({window:a}).value?"dark":"light");return D({get(){return r.value==="dark"},set(i){const l=i?"dark":"light";s.value===l?r.value="auto":r.value=l}})}const Ee={__name:"ToggleDark",setup(e){const t=De(),n=me(t);return(a,r)=>(re(),oe("button",{onClick:r[0]||(r[0]=s=>j(n)()),class:"shadow-xl fixed bottom-16 left-0 right-0 z-[100] w-10 h-10 lg:w-16 lg:h-16 left-16 bg-gray-800 dark:bg-white rounded-full text-white dark:text-black font-semibold border"},ae(j(t)?"LHT":"DRK"),1))}};export{Ee as _};
