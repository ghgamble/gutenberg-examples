import React from 'react';
import { createRoot } from 'react-dom/client';
import "./frontend.scss";
 
const divsToUpdate = document.querySelectorAll(".mc-update-me");
 
divsToUpdate.forEach(function (div) {
  createRoot(div).render(<Quiz />)
  div.classList.remove("mc-update-me");
});
 
function Quiz() {
  return (
    <div className="mc-frontend">
      Hello From React.
    </div>
  )
}

export default Quiz;