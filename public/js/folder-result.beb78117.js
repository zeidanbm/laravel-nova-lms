(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["folder-result"],{"0bd2":function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("dt",{staticClass:"text-sm leading-5 font-medium text-gray-500"},[s("picture",[s("img",{attrs:{src:t.src,alt:t.alt}})])])},r=[],l={name:"CardHeader",props:{src:{type:String},alt:{type:String}}},i=l,n=s("2877"),u=Object(n["a"])(i,a,r,!1,null,null,null);e["a"]=u.exports},"17fa":function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("dt",{staticClass:"mb-3 text-sm leading-5 font-medium text-gray-500"},[t._v(" "+t._s(t.$t("Tags"))+" ")]),t._l(t.tags,(function(e,a){return s("dd",{key:"tag-"+a,staticClass:"inline-flex items-center ml-2 mb-1 px-3 py-1 rounded-full text-sm font-medium leading-5 bg-gray-100 text-gray-900"},[t._v(" "+t._s(e)+" ")])}))],2)},r=[],l={name:"CardTags",props:{tags:{type:Array}}},i=l,n=s("2877"),u=Object(n["a"])(i,a,r,!1,null,null,null);e["a"]=u.exports},"4f6a":function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("a",{staticClass:"bg-white shadow overflow-hidden cursor-pointer rounded-lg hover:shadow-xl transition-shadow ease-in-out duration-300",attrs:{href:"/quote/"+t.item.model_id}},[s("CardHeader",{attrs:{title:t.item.authors,type:t.item.type}}),s("div",{staticClass:"px-4 py-5 sm:px-6"},[s("p",{staticClass:"mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2"},[t._v(" "+t._s(t.item.body)+" ")])])],1)},r=[],l=s("7c84"),i={name:"QuoteResult",components:{CardHeader:l["a"]},props:{item:{type:Object,required:!0}}},n=i,u=s("2877"),o=Object(u["a"])(n,a,r,!1,null,null,null);e["default"]=o.exports},6756:function(t,e,s){"use strict";s.r(e);var a,r,l=s("2877"),i={},n=Object(l["a"])(i,a,r,!1,null,null,null);e["default"]=n.exports},"7c84":function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"flex justify-between px-4 py-5 border-b border-gray-200 sm:px-6"},[s("div",[s("h3",{staticClass:"text-lg leading-6 font-medium text-gray-900"},[t._v(" "+t._s(t.title)+" ")]),s("p",{staticClass:"mt-1 max-w-2xl text-sm leading-5 text-gray-500"},[t._v(" "+t._s(t.subTitle)+" ")])]),s("div",[s("span",{staticClass:"px-3 py-1 rounded-sm text-sm leading-5 bg-blue-100 text-blue-700"},[t._v(" "+t._s(t.$t(t.type))+" ")])])])},r=[],l={name:"CardHeader",props:{title:{type:String},type:{type:String},subTitle:{type:String,default:""}}},i=l,n=s("2877"),u=Object(n["a"])(i,a,r,!1,null,null,null);e["a"]=u.exports},"9d61":function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("dt",{staticClass:"text-sm leading-5 font-medium text-gray-500"},[t._v(" "+t._s(t.$t("Publishers"))+" ")]),t._l(t.publishers,(function(e,a){return s("dd",{key:"publishers-"+a,staticClass:"mt-1 text-sm leading-5 text-gray-900"},[t._v(" "+t._s(e)+" ")])}))],2)},r=[],l={name:"CardPublishers",props:{publishers:{type:Array}}},i=l,n=s("2877"),u=Object(n["a"])(i,a,r,!1,null,null,null);e["a"]=u.exports},cce8:function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("a",{staticClass:"bg-white shadow overflow-hidden cursor-pointer rounded-lg hover:shadow-xl transition-shadow ease-in-out duration-300",attrs:{href:"/book/"+t.item.slug}},[s("CardHeader",{attrs:{title:t.item.title,"sub-title":t.item.sub_title,type:t.item.type}}),s("div",{staticClass:"px-4 py-5 sm:px-6"},[s("dl",{staticClass:"grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2"},[s("div",{staticClass:"sm:col-span-1"},[s("CardImage",{attrs:{src:t.item.cover_thumbnail,alt:t.item.title}})],1),s("CardAuthors",{staticClass:"sm:col-span-1",attrs:{authors:t.item.authors}}),s("div",{staticClass:"sm:col-span-1"}),s("CardPublishers",{staticClass:"sm:col-span-1",attrs:{publishers:t.item.publishers}}),s("CardTags",{staticClass:"sm:col-span-2",attrs:{tags:t.item.tags}})],1)])],1)},r=[],l=s("7c84"),i=s("17fa"),n=s("0bd2"),u=s("e227"),o=s("9d61"),d={name:"FolderResult",components:{CardHeader:l["a"],CardTags:i["a"],CardImage:n["a"],CardAuthors:u["a"],CardPublishers:o["a"]},props:{item:{type:Object,required:!0}}},c=d,m=s("2877"),p=Object(m["a"])(c,a,r,!1,null,null,null);e["default"]=p.exports},e227:function(t,e,s){"use strict";var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("dt",{staticClass:"text-sm leading-5 font-medium text-gray-500"},[t._v(" "+t._s(t.$t("Authors"))+" ")]),t._l(t.authors,(function(e,a){return s("dd",{key:"authors-"+a,staticClass:"mt-1 text-sm leading-5 text-gray-900"},[t._v(" "+t._s(e)+" ")])}))],2)},r=[],l={name:"CardAuthors",props:{authors:{type:Array}}},i=l,n=s("2877"),u=Object(n["a"])(i,a,r,!1,null,null,null);e["a"]=u.exports}}]);