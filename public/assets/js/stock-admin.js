$(document).ready(function() {
    $('#fav-table').tablesorter();
});

window.onload = () => {
    const form = document.getElementById("adminFilter");
    form.querySelectorAll("input[type='date'],input[type='text']").forEach(element => {
	element.addEventListener('keypress', (e) => {
	    if (e.keyCode !== 13 || e.isComposing) return;
	    if (form.reportValidity()) form.submit();
	});
    })
}

const setCurrentTime = () => {
    var now = new Date();
    // 「年」「月」「日」「曜日」を Date オブジェクトから取り出してそれぞれに代入
    var m = now.getMonth() + 1;
    var d = now.getDate();
    var w = now.getDay();
    var h = now.getHours();
    var i = now.getMinutes();
    var s = now.getSeconds();
    // 曜日の表記を文字列の配列で指定
    var wNames = ['日', '月', '火', '水', '木', '金', '土'];
    //ゼロ埋め処理
    m = ('00' + m).slice(-2);
    d = ('00' + d).slice(-2);
    h = ('00' + h).slice(-2);
    i = ('00' + i).slice(-2);
    s = ('00' + s).slice(-2);

    var time = m + '/' + d + ' ' + h + ':' + i;

    return time;
}

const dialogClose = (dialog) => {
    dialog.remove();
};

window.addEventListener('keypress', keyPressEvent = (e) => {
    if (e.shiftKey == true && e.keyCode == 13) {
	//Enter + Shift
    } else if (e.ctrlKey == true && e.keyCode == 10) {
	//Enter + CtrlKey
	const regex = /inputText-(.*)/;
	if (!regex.test(e.target.id)) return;
	const id = e.target.id;
	const fileId = id.match(regex)[1];
	const data = {
	    value: fileId
	}
	sendPost(data);
    } else if (e.altKey == true && e.keyCode == 13) {
	//Enter + Alt
    } else if (e.keyCode == 13) {
	const regex = /inputText-(.*)/;
	if (!regex.test(e.target.id)) {
	    event.preventDefault();
	} else {
	    e.target.rows++;
	}
    }

    return false;
});

window.addEventListener('keydown', inputTextMoveEvent = (e) => {
    if (event.code == "ArrowDown") {
	if (e.isComposing) return
	const inputTextElements = document.querySelectorAll("[id^='inputText']");
	const elements = [].slice.call(inputTextElements);
	const index = elements.indexOf(e.target); // 2
	if (index + 1 < elements.length && e.target.selectionStart == e.target.value.length) {
	    inputTextElements[index + 1].focus();
	}

    } else if (event.code == "ArrowUp") {
	if (e.isComposing) return
	const inputTextElements = document.querySelectorAll("[id^='inputText']");
	const elements = [].slice.call(inputTextElements);
	const index = elements.indexOf(e.target); // 2
	if (index - 1 >= 0 && e.target.selectionStart == 0) {
	    inputTextElements[index - 1].focus();
	}
    }

    return false;
});

const preOrderDialogComponent = (event) => {

    const fileId = event.getAttribute("value");

    const dialogDiv1 = document.createElement("div");
    dialogDiv1.className = "fixed z-10 inset-0 overflow-y-auto";
    dialogDiv1.ariaModal = true;

    const dialogDiv2 = document.createElement("div");
    dialogDiv2.className =
	"flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0";
    dialogDiv1.appendChild(dialogDiv2);

    const dialogDiv3_1 = document.createElement("div");
    dialogDiv3_1.id = "dialogComponent";
    dialogDiv3_1.className =
	"fixed z-99 inset-0 bg-gray-500 bg-opacity-75 transition-opacity";
    dialogDiv3_1.ariaHidden = true;
    dialogDiv3_1.onclick = function(e) {
	if (e.target.id !== "dialogComponent") {
	    return;
	}
	dialogClose(dialogDiv1);
    };
    dialogDiv2.appendChild(dialogDiv3_1);

    const dialogSpan1 = document.createElement("span");
    dialogSpan1.className = "hidden sm:inline-block sm:align-middle sm:h-screen";
    dialogSpan1.ariaHidden = true;
    dialogSpan1.innerText = "";
    dialogDiv3_1.appendChild(dialogSpan1);

    const dialogDiv3_2 = document.createElement("div");
    dialogDiv3_2.className =
	"inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full";
    dialogDiv3_2.setAttribute("x-show", "open");
    dialogDiv3_2.setAttribute("x-transition:enter", "ease-out duration-300");
    dialogDiv3_2.setAttribute(
	"x-transition:enter-start",
	"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    );
    dialogDiv3_2.setAttribute(
	"x-transition:enter-end",
	"opacity-100 translate-y-0 sm:scale-100"
    );
    dialogDiv3_2.setAttribute("x-transition:leave", "ease-in duration-200");
    dialogDiv3_2.setAttribute(
	"x-transition:leave-start",
	"opacity-100 translate-y-0 sm:scale-100"
    );
    dialogDiv3_2.setAttribute(
	"x-transition:leave-end",
	"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    );
    dialogDiv3_2.setAttribute(
	"x-description",
	"Modal panel, show/hide based on modal state."
    );
    dialogDiv3_1.appendChild(dialogDiv3_2);

    const dialogDiv4_1 = document.createElement("div");
    dialogDiv4_1.className = "bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4";
    dialogDiv3_2.appendChild(dialogDiv4_1);

    const dialogDiv5 = document.createElement("div");
    dialogDiv5.className = "sm:flex sm:items-start";
    dialogDiv4_1.appendChild(dialogDiv5);

    const dialogDiv6_1 = document.createElement("div");
    dialogDiv6_1.className =
	`mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10`;
    dialogDiv5.appendChild(dialogDiv6_1);

    const dialogSvg1 = document.createElementNS(
	"http://www.w3.org/2000/svg",
	"svg"
    );
    dialogSvg1.setAttribute("class", `h-6 w-6 text-yellow-600`);
    dialogSvg1.ariaHidden = true;
    dialogSvg1.setAttribute("fill", "none");
    dialogSvg1.setAttribute("viewBox", "0 0 24 24");
    dialogSvg1.setAttribute("stroke", "currentColor");
    dialogDiv6_1.appendChild(dialogSvg1);

    const dialogPath1 = document.createElementNS(
	"http://www.w3.org/2000/svg",
	"path"
    );
    dialogPath1.setAttribute("class", `h-6 w-6 text-yellow-600`);
    dialogPath1.setAttribute("stroke-linecap", "round");
    dialogPath1.setAttribute("stroke-linejoin", "round");
    dialogPath1.setAttribute("stroke-width", "2");
    dialogPath1.setAttribute(
	"d",
	"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
    );
    dialogSvg1.appendChild(dialogPath1);

    const dialogDiv6_2 = document.createElement("div");
    dialogDiv6_2.className = "mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left";
    dialogDiv5.appendChild(dialogDiv6_2);

    const dialogHeader1 = document.createElement("h3");
    dialogHeader1.className = "text-lg leading-6 font-medium text-gray-900";
    dialogHeader1.id = "modal-title";
    dialogHeader1.innerText = "仮発注入力";
    dialogDiv6_2.appendChild(dialogHeader1);

    const dialogDiv7 = document.createElement("div");
    dialogDiv7.className = "mt-2";
    dialogDiv7.id = "inErrorMessage";
    dialogDiv6_2.appendChild(dialogDiv7);

    const dialogP1 = document.createElement("p");
    dialogP1.className = "mb-2 text-sm text-gray-500";
    dialogP1.innerText = "納品場所と日程を入力し、送信を押してください。";
    dialogDiv7.appendChild(dialogP1);

    const inputP1 = document.createElement("p");
    inputP1.innerText = "納品先"
    dialogDiv7.appendChild(inputP1);

    const preOrderPlaceInput = document.createElement("input");
    preOrderPlaceInput.className = "w-full block border border-black rounded";
    preOrderPlaceInput.type = "text";
    preOrderPlaceInput.id = "preOrderPlace";
    preOrderPlaceInput.placeholder = "納品先を入力してください。"
    //console.log(document.getElementById(`prefCity-${fileId}`).innerText);
    preOrderPlaceInput.value = document.getElementById(`prefCity-${fileId}`).innerText;
    dialogDiv7.appendChild(preOrderPlaceInput);

    const inputP2 = document.createElement("p");
    inputP2.innerText = "納品日"
    dialogDiv7.appendChild(inputP2);

    const preOrderStartDateInput = document.createElement("input");
    preOrderStartDateInput.className = "inline border border-black rounded";
    preOrderStartDateInput.type = "date";
    preOrderStartDateInput.id = "preOrderStartDate";
    preOrderStartDateInput.onchange = (e) => {
	preOrderEndDateInput.value = e.target.value;
    }
    dialogDiv7.appendChild(preOrderStartDateInput);

    const inputSpan1 = document.createElement("span");
    inputSpan1.innerText = "～"
    dialogDiv7.appendChild(inputSpan1);

    const preOrderEndDateInput = document.createElement("input");
    preOrderEndDateInput.className = "inline border border-black rounded";
    preOrderEndDateInput.type = "date";
    preOrderEndDateInput.id = "preOrderEndDate";
    dialogDiv7.appendChild(preOrderEndDateInput);

    const dialogDiv4_2 = document.createElement("div");
    dialogDiv4_2.className =
	"bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse";
    dialogDiv3_2.appendChild(dialogDiv4_2);

    const dialogButton1_1 = document.createElement("button");
    dialogButton1_1.className =
	`w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm`;
    dialogButton1_1.innerText = "送信";
    dialogButton1_1.value = fileId;
    dialogButton1_1.onclick = async (e) => {
	const preOrderValues = {
	    fileId: e.target.value,
	    place: document.getElementById("preOrderPlace").value,
	    startDate: document.getElementById("preOrderStartDate").value,
	    endDate: document.getElementById("preOrderEndDate").value,
	};
	await doPreOrder(preOrderValues);
	// document.getElementById(`preOrderCheck-${e.target.value}`).checked = true;
    };
    dialogDiv4_2.appendChild(dialogButton1_1);

    const dialogButton1_2 = document.createElement("button");
    dialogButton1_2.className =
	"mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm";
    dialogButton1_2.innerText = "キャンセル";
    dialogButton1_2.onclick = () => dialogClose(dialogDiv1);
    dialogDiv4_2.appendChild(dialogButton1_2);

    const wrapper = document.getElementById("wrapper");
    wrapper.appendChild(dialogDiv1);
};

const doPreOrder = (values) => {
	const fileId = values.fileId;
	if (values.place == "") {
		let errorMessage = document.getElementById("errorMessage") || undefined;
		if (errorMessage) errorMessage.remove();
		errorMessage = document.createElement("p");
		errorMessage.id = "errorMessage";
		errorMessage.className = "text-red-500";
		errorMessage.innerHTML = "納品先をご入力ください。";
		const errorMessageField = document.getElementById("inErrorMessage");
		errorMessageField.appendChild(errorMessage);
		return
	}

	if (values.startDate == "" || values.endDate == "" || values.startDate > values.endDate) {
		let errorMessage = document.getElementById("errorMessage") || undefined;
		if (errorMessage) errorMessage.remove();
		errorMessage = document.createElement("p");
		errorMessage.id = "errorMessage";
		errorMessage.className = "text-red-500";
		errorMessage.innerHTML = "納品日を正しくご入力ください。";
		const errorMessageField = document.getElementById("inErrorMessage");
		errorMessageField.appendChild(errorMessage);
		return
	}


	const params = new URLSearchParams();
	const token = 'asdfadfasdfasdfadf';
	params.append('place', values.place);
	params.append('startDate', values.startDate);
	params.append('endDate', values.endDate);
	params.append('token', token);

	const params2 = new URLSearchParams();
	const userId = 'asdfadfasdfasdfadf';
	params2.append('userId', userId);
	params2.append('proxyUserId', 1);
	params2.append('body', "仮発注をしました。");
	params2.append('token', token);

	const postParams = new URLSearchParams();
	postParams.append('body', "新規の仮発注がありました。");

	axios.all([
		axios.post(`/api/preorder/items/${fileId}`,
			params),
		axios.post(`/api/stock/posts/${fileId}`,
			params2),
		axios.patch(
			`/api/stock/items/${fileId}?status=0&token=${token}`
		),
		axios.patch(
			`/api/stock/items/${fileId}?condition=1&isChangeSameOrder=1&token=${token}`
		),
		axios.patch(
			`/api/stock/items/${fileId}?condition=2&isChangeSameOrderAndNotSameSupplier=1&token=${token}`
		),
		axios.post(
			`/api/stock/notify/${fileId}?token=${token}`,
			postParams
		)
	]).then(axios.spread((res1, res2, res3, res4, res5, res6) => {
		// console.log(res1, res2, res3, res4, res5);
		//location.reload()
	}))
}

const resetValue = (id) => {
    const element = document.getElementById(id);
    element.value = "";
    if(element.type == "date"){
        element.type = 'text';
    }
}

const toggleMall = () => {
    const mallFilterItems = document.querySelectorAll('#mallFilterItems input[type="checkbox"]');
    if(document.getElementById("adminFilter").domainFilter.value === "dai2"){
        for(let i = 0; i < mallFilterItems.length; i++){
            mallFilterItems[i].disabled = true;
        }
    }else{
        for(let i = 0; i < mallFilterItems.length; i++){
            mallFilterItems[i].disabled = false;
        }
    }
}

const allCheck = (e) => {
    const group = document.querySelectorAll(`input.checkGroup${e.id}`);
    group.forEach(element => element.checked = e.checked ? true : false);
}

const searchBarToggle = () => {
    const value = localStorage.getItem("openSearchBarToggle");
    if(value == "true"){
        document.cookie = "openSearchBarToggle=;max-age=0";
    }else{
        document.cookie = "openSearchBarToggle=true";
    }
}

const getCookieValue = (keyName) => {
    const cookies = document.cookie.split(';'); // ;で分割し配列に
    for(let cookie of cookies){ //一つ一つ取り出して
        const keyValue = cookie.split('='); //さらに=で分割して配列に
        if( keyValue[0] == keyName){ // 取り出したいkeyと合致したら
            return keyValue[1];
        }
    }
}

const openToOptionDialog = async (e) => {
    const data = JSON.parse(e.target.getAttribute("value"));
    const orderId = data.orderId;
    const supplier = data.supplier;
    const groupId = data.groupId;
    const status = e.target.getAttribute("metadata");

    const optionDialog = document.createElement('div');
    optionDialog.id = orderId;
    optionDialog.className = 'absolute z-10 border border-gray-300 rounded-md shadow-xl bg-white';
    optionDialog.style =
	'width: 100px; height: 50px; top: ${e.pageY - 15}px; left: ${e.pageX - 85}px;';

    const inputGroup = document.createElement('div');
    inputGroup.id = orderId;

    if (status == 2) {
	const doAddOrderForm = document.createElement('form');
	doAddOrderForm.name = 'addOrderForm';
	doAddOrderForm.className = 'm-0';

	const addOrderIdInputHidden = document.createElement('input');
	addOrderIdInputHidden.type = 'hidden';
	addOrderIdInputHidden.name = 'orderId';
	addOrderIdInputHidden.value = orderId;
	doAddOrderForm.appendChild(addOrderIdInputHidden);

	const addOrderSupplierInputHidden = document.createElement('input');
	addOrderSupplierInputHidden.type = 'hidden';
	addOrderSupplierInputHidden.name = 'supplier';
	addOrderSupplierInputHidden.value = supplier;
	doAddOrderForm.appendChild(addOrderSupplierInputHidden);

	const addOrderInputHidden = document.createElement('input');
	addOrderInputHidden.type = 'hidden';
	addOrderInputHidden.name = 'option';
	addOrderInputHidden.value = 'add';
	doAddOrderForm.appendChild(addOrderInputHidden);

	const addOrderInputButton = document.createElement('input');
	addOrderInputButton.type = 'button';
	addOrderInputButton.value = '商品追加する';
	addOrderInputButton.style = 'cursor: pointer';
	addOrderInputButton.onclick = () => {
	    // window.open('', 'new_window');
	    window.open("about:blank", "new_window", "menubar=no");
	    document.addOrderForm.action =
		"http://mt-d.mitaden.local/stock/form/index.php";
	    document.addOrderForm.method = 'POST';
	    document.addOrderForm.target = 'new_window';
	    document.addOrderForm.submit();
	};
	doAddOrderForm.appendChild(addOrderInputButton);
	inputGroup.appendChild(doAddOrderForm);
    }

    const doDuplicateOrderForm = document.createElement('form');
    doDuplicateOrderForm.name = 'duplicateOrderForm';
    doDuplicateOrderForm.className = 'm-0';

    const duplicateOrderIdInputHidden = document.createElement('input');
    duplicateOrderIdInputHidden.type = 'hidden';
    duplicateOrderIdInputHidden.name = 'orderId';
    duplicateOrderIdInputHidden.value = orderId;
    doDuplicateOrderForm.appendChild(duplicateOrderIdInputHidden);

    const duplicateOrderSupplierInputHidden = document.createElement('input');
    duplicateOrderSupplierInputHidden.type = 'hidden';
    duplicateOrderSupplierInputHidden.name = 'supplier';
    duplicateOrderSupplierInputHidden.value = supplier;
    doDuplicateOrderForm.appendChild(duplicateOrderSupplierInputHidden);

    const duplicateOrderInputHidden = document.createElement('input');
    duplicateOrderInputHidden.type = 'hidden';
    duplicateOrderInputHidden.name = 'option';
    duplicateOrderInputHidden.value = 'duplicate';
    doDuplicateOrderForm.appendChild(duplicateOrderInputHidden);

    const duplicateOrderInputButton = document.createElement('input');
    duplicateOrderInputButton.type = 'button';
    duplicateOrderInputButton.value = '複製する';
    duplicateOrderInputButton.style = 'cursor: pointer';
    duplicateOrderInputButton.onclick = () => {
	// window.open('', 'new_window');
	window.open("about:blank", "new_window", "menubar=no");
	document.duplicateOrderForm.action =
	    "http://mt-d.mitaden.local/stock/form/supplier.php";
	document.duplicateOrderForm.method = 'POST';
	document.duplicateOrderForm.target = 'new_window';
	document.duplicateOrderForm.submit();
    };
    doDuplicateOrderForm.appendChild(duplicateOrderInputButton);
    inputGroup.appendChild(doDuplicateOrderForm);

    const closeAction = (e) => {
	if (e.target.id === groupId) {
	    return;
	}
	dialogClose(optionDialog);
	window.removeEventListener('click', closeAction);
    }

    optionDialog.appendChild(inputGroup);

    const wrapper = document.getElementById('wrapper');
    // 要素を追加
    wrapper.appendChild(optionDialog);

    window.addEventListener('click', closeAction);

}

const sendPost = async (e) => {
    e.disabled = true;
    const itemId = e.value;
    const currentTextField = document.getElementById('inputText-${itemId}');
    const body = currentTextField.value.replace(/\n/g, '<br>');
    if (body == "") {
	return
    }
    const userId = '99';
    const params = new URLSearchParams();
    const token = 'adsfadfasdfadfadsfadsfadsfasdfadsf';
    params.append('userId', userId);
    params.append('body', body);
    params.append('token', token);

    const postParams = new URLSearchParams();
    postParams.append('body', "在庫確認の連絡がありました。");

    const postsColumn = document.getElementById(`posts-${itemId}`);
    postsColumn.innerHTML +=
	'<p class="text-right"><span class="px-1 text-gray-400">${setCurrentTime()}</span><span class="text-left inline-block rounded px-1 mb-1 bg-blue-100">${body}</span></p>';
    postsColumn.parentNode.style = "background-color: white";
    currentTextField.value = "";

    await axios.all([
	axios.post('http://mt-d.mitaden.local/api/stock/posts/${itemId}',
		   params),
	axios.patch(
	    'http://mt-d.mitaden.local/api/stock/items/${itemId}?status=0&token=${token}'
	),
	axios.post(
	    'http://mt-d.mitaden.local/api/stock/notify/${itemId}?token=${token}',
	    postParams
	)
    ]).then(axios.spread((res1, res2) => {
	console.log(res1, res2);
	if (res1.data.error == true) {
	    isErrorDialogComponent(res1.data);
	    return
	}
	e.disabled = false;
    }))
}

const proxySendPost = async (e) => {
    const data = JSON.parse(e.value);
    const itemId = data.hashId;
    const currentTextField = document.getElementById('inputText-${itemId}');
    const body = currentTextField.value.replace(/\n/g, '<br>');
    if (body == "") {
	return
    }
    const userId = '99';
    const proxyUserId = data.proxyUserId;
    const params = new URLSearchParams();
    const token = 'asdfadfadsfadsfadfasfasdfadfasdfadsf';
    params.append('userId', proxyUserId);
    params.append('proxyUserId', userId);
    params.append('body', body);
    params.append('token', token);

    await axios.all([
	axios.post('http://mt-d.mitaden.local/api/stock/posts/${itemId}',
		   params),
	axios.patch(
	    'http://mt-d.mitaden.local/api/stock/items/${itemId}?status=1&token=${token}'
	)
    ]).then(axios.spread((Result1, Result2) => {
	if (Result1.data.error == true) {
	    isErrorDialogComponent(Result1.data);
	    return
	}
	const postsColumn = document.getElementById(`posts-${itemId}`);
	postsColumn.innerHTML +=
	    '<p class="text-right"><span class="px-1 text-gray-400">${setCurrentTime()}</span><span class="text-left inline-block rounded px-1 mb-1 bg-blue-100">${body}(代理)</span></p>';
	postsColumn.style = "background-color: rgba(254,226,226)";
	currentTextField.value = "";
    }))
}
