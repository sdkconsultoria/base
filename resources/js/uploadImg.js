
var // where files are dropped + file selector is opened
	dropRegion = document.getElementById("drop-region"),
	// where images are previewed
	imagePreviewRegion = document.getElementById("image-preview");


// open file selector when clicked on the drop region
var fakeInput = document.createElement("input");

if (dropRegion) {
    fakeInput.type = "file";
    fakeInput.accept = "image/*";
    fakeInput.multiple = true;
    dropRegion.addEventListener('click', function() {
        fakeInput.click();
    });

    fakeInput.addEventListener("change", function() {
        var files = fakeInput.files;
        handleFiles(files);
    });


    function preventDefault(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    dropRegion.addEventListener('dragenter', preventDefault, false)
    dropRegion.addEventListener('dragleave', preventDefault, false)
    dropRegion.addEventListener('dragover', preventDefault, false)
    dropRegion.addEventListener('drop', preventDefault, false)

    dropRegion.addEventListener('drop', handleDrop, false);

}


function handleDrop(e) {
	var dt = e.dataTransfer,
		files = dt.files;

	handleFiles(files)
}




function handleFiles(files) {
	for (var i = 0, len = files.length; i < len; i++) {
		if (validateImage(files[i]))
			previewAnduploadImage(files[i]);
	}
}

function validateImage(image) {
	// check the type
	var validTypes = ['image/jpeg', 'image/png', 'image/gif'];
	if (validTypes.indexOf( image.type ) === -1) {
		alert("Invalid File Type");
		return false;
	}

	// check the size
	var maxSizeInBytes = 10e6; // 10MB
	if (image.size > maxSizeInBytes) {
		alert("File too large");
		return false;
	}

	return true;

}

function previewAnduploadImage(image) {

	// container
	var imgView = document.createElement("div");
	imgView.className = "image-view";
    imgView.classList.add("w-1/12");

	imagePreviewRegion.appendChild(imgView);

	// previewing image
	var img = document.createElement("img");
	imgView.appendChild(img);

	// progress overlay
	var overlay = document.createElement("div");
	overlay.className = "overlay";
	imgView.appendChild(overlay);


	// read the image...
	var reader = new FileReader();
	reader.onload = function(e) {
		img.src = e.target.result;
	}
	reader.readAsDataURL(image);

	// create FormData
	var formData = new FormData();
	formData.append('image', image);

	// upload the image
	var uploadLocation = dropRegion.dataset.upload;

    var target = dropRegion.dataset.target;

	var ajax = new XMLHttpRequest();
	ajax.open("POST", uploadLocation, true);
    ajax.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

	ajax.onreadystatechange = function(e) {
		if (ajax.readyState === 4) {
			if (ajax.status === 200) {
				imgView.removeChild(img);
                if (target) {
                    let imgLoad = document.getElementById(target);
                    imgLoad.src = ajax.responseText;
                } else {
                    let json = JSON.parse(ajax.responseText);
                    let table = document.getElementById(json.table);
                    table.tBodies[0] .innerHTML += json.data;
                    window.imageable();
                    window.initDelete();
                }
			} else {
				// error!
			}
		}
	}

	ajax.upload.onprogress = function(e) {

		// change progress
		// (reduce the width of overlay)

		var perc = (e.loaded / e.total * 100) || 100,
			width = 100 - perc;

		overlay.style.width = width;
	}

	ajax.send(formData);

}
