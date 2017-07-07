.pageText, #navOuter-tNav:not(.mNav) #navInner-tNav,
.mi-fhBanImg{
	padding-left:15px;
	padding-right:15px;
}

h1, 
.icp-fhBanImg{
	font-size: 2rem;
}

h2, 
.idc-fhBanImg{
	font-size:1.5rem;
}

.pcpy {
	padding-top:125px;
    position: relative;
    z-index: 1;
    overflow: hidden;
}

#pcpy1 {
	padding-top: 100vh;
}

.pc{
    overflow: hidden;
    position: relative;
}

.pc a {
    text-decoration: none;
}

.pageText {
    background: #fff none repeat scroll 0 0;
    margin: 0 auto;
    padding-bottom: 10vh;
    padding-top: 10vh;
    position: relative;
    width: 100%;
}

.pc p {
    padding-bottom: 35px;
}

.expandBtn{
    background-color: red;
    cursor: pointer;
    height: 100%;
    left: 0;
    position: absolute !important;
    top: 0;
    width: 100%;
    display: block;
}

.closeBtn{
	background-color: blue;
    cursor: pointer;
    height: 100%;
    right: 0;
    position: absolute !important;
    top: 0;
    width: 100%;
    display: none;
}

.expanded .closeBtn {
	display: block;
}

.expanded .expandBtn {
    display: none;
}

.mfp{
    padding-bottom: 60px;
    padding-top: 50px;
    position: relative;
    text-align: center;
}

.mfp a{
    color: rgb(77, 77, 79);
    display: inline-block !important;
    height: 33px;
    line-height: 33px;
    text-align: center;
    width: 33px;
    border: 1px solid transparent;
    margin: 0 15px;
    
    -webkit-border-radius: 17px;
    -moz-border-radius: 17px;
    border-radius: 17px;
}

.pgcClicked, .mfp a:hover {
    border-color: rgb(77, 77, 79) !important;
}

/****************************************************/

input[type="radio"] {
  position: absolute;
  
  &:focus + label {
    color: black;
    background-color: wheat;
  }
}


.togglebox label {
  position: relative;
  display: block;
  cursor: pointer;
  background: #c69;
  color: white;
  padding: .5em;
  border-bottom: 1px solid white;
}


section {
  height: 0;
  transition: .3s all;
  overflow: hidden;
}


#toggle1:checked ~ #content1,
#toggle2:checked ~ #content2,
#toggle3:checked ~ #content3,
#toggle4:checked ~ #content4 {
  
  height: 150px;
}




p {
  padding: 0 2em
}

.togglebox {
  margin: 0 auto;
  width: 50%;
  border: 1px solid #c69;
}




.tabs {
 font-size: 1.1em;
  position: relative;  
  min-height: 180px;
  display: block;
  margin: 1em auto 0;
  width: 460px;
}

.tab {
  float: left;
   position: unset;
}

.tab label {
  cursor: pointer;
  background: #c69;
  font-size: 1.2em;
  border-radius: 5px 5px 0 0;
  padding: .5em 1em;
}

.tab [type=radio] {
  position: absolute;
  height: 0;
  width: 0;
  overflow: hidden;
  clip: rect(0,0,0,0);
  
  
}

.tab [type=radio]:focus + label {
    outline: 2px dotted #000;
  }

.content {
  background: wheat;
  border: 1px solid #c69;
  border-radius: 0 5px 5px;
  padding: .5em 2em;
  max-width: 450px;
  position: absolute;
  top: 2em; left: 0; right: 0; bottom: 0;
  opacity: 0;
}

[type=radio]:checked ~ label {
  z-index: 2;
  background: #c99;
}

[type=radio]:checked ~ label ~ .content {
  z-index: 1;
  opacity: 1;
}
#pcpy2483 {
	padding-top: 0;
}