(function () {
    function sendHeight() {
        const height = document.documentElement.scrollHeight;

        console.log("sendHeight", height);
        try {
            const iframe = window.frameElement;
            if (iframe) {
                iframe.style.height = `${height}px`;
            } else {
                throw new Error("iframe not found");
            }
        } catch (e) {
            window.parent.postMessage(
                {
                    type: "unfold-iframe-resize",
                    height,
                },
                "*"
            );
        }
    }

    let sendHeightTimeout = null;

    function sendDelayedHeight() {
        console.log("sendDelayedHeight");
        if (sendHeightTimeout) {
            clearTimeout(sendHeightTimeout);
        }
        sendHeightTimeout = setTimeout(sendHeight, 50);
    }

    function init() {
        const mutation = new window.MutationObserver(sendDelayedHeight);
        mutation.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
        });
        sendHeight();
    }

    document.addEventListener("DOMContentLoaded", init);
    document.addEventListener('click', sendDelayedHeight);
    document.addEventListener('resize', sendDelayedHeight);
})();
