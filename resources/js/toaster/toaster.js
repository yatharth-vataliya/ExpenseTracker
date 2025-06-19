var toasterElement = null;

const defaultTimeoutMiliseconds = 5000;

export async function showToaster(type = "info", text = "This is just info text") {
    toasterElement = document.getElementById("toaster-container");
    if (toasterElement == null) {
        return;
    }

    const liElement = document.createElement("li");
    liElement.innerText = text;
    let classString = "w-60 overflow-hidden font-semibold p-2 mt-2 break-words text-white shadow-md rounded-sm text-wrap text-center border-s-8 relative before:absolute before:h-1 before:w-full before:bottom-0 before:left-0 before:animate-toaster-progress animate-show-toaster";
    const toasterTypesClass = {
        "success": "border-red-700 bg-red-500 before:bg-red-900",
        "info": "border-blue-700 bg-blue-400 before:bg-blue-900",
        "warning": "border-yellow-700 bg-yellow-500 before:bg-yellow-900",
        "error": "border-green-700 bg-green-500 before:bg-green-900",
    };
    classString = classString + " " + (toasterTypesClass[type] ? toasterTypesClass[type] : toasterTypesClass["info"]);
    liElement.className = classString;

    liElement.onmouseover = () => {
        clearTimeout(liElement.timerId);
        liElement.classList.remove('animate-hide-toaster', 'before:animate-toaster-progress');
    }

    liElement.onmouseleave = () => {
        liElement.classList.add('before:animate-toaster-progress');
        liElement.timerId = setTimeout(() => removeToaster(liElement), defaultTimeoutMiliseconds);
    }

    toasterElement.appendChild(liElement);

    liElement.timerId = setTimeout(() => {
        removeToaster(liElement);
    }, defaultTimeoutMiliseconds);
}

function removeToaster(toaster) {
    toaster.classList.remove("animate-show-toaster");
    toaster.classList.add("animate-hide-toaster");
    if (toaster.timerId) clearTimeout(toaster.timerId);
    setTimeout(() => toaster.remove(), 400);
}
