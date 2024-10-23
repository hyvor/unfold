(function () {
    function sendHeight() {
        const height = document.documentElement.scrollHeight;

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

    let mutationCallTimeout = null;

    function processMutations() {
        if (mutationCallTimeout) {
            clearTimeout(mutationCallTimeout);
        }
        mutationCallTimeout = setTimeout(sendHeight, 50);
    }

    function init() {
        const mutation = new window.MutationObserver(processMutations);
        mutation.observe(document.body, {
            childList: true,
            subtree: true,
        });
        sendHeight();
    }

    document.addEventListener("DOMContentLoaded", init);
})();
