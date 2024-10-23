(function () {
	window.addEventListener('message', function (event) {
		const source = event.source;
		const iframes = document.querySelectorAll('iframe');

		for (let iframe in iframes) {
			if (iframes[iframe].contentWindow === source) {
				console.log('found the source', event.data);
				if (event.data.type === 'unfold-iframe-resize') {
					iframes[iframe].style.height = `${event.data.height}px`;
				}
			}
		}
	});
})();
