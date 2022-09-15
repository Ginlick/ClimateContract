function togglePop(popId){
  pop = document.getElementById(popId);
  if (pop == null){return false;}
  if (pop.style.display == "block"){
    pop.style.display = "none";
    document.body.style.overflow = "auto";
    pop.classList.remove("shown");
  }
  else {
    document.body.style.overflow = "hidden";
    pop.style.display = "block";
    pop.scrollTop = 0;
    pop.classList.add("shown");
  }
  return true;
}﻿
