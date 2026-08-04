(function () {
    'use strict';

    if (!window.location.hostname.endsWith('.vercel.app')) {
        return;
    }

    const productionOrigin = 'https://glassprinting.ie/';

    function routeContactLinks(root) {
        const links = [];

        if (root.matches && root.matches('a[href^="contact.php"]')) {
            links.push(root);
        }

        if (root.querySelectorAll) {
            links.push(...root.querySelectorAll('a[href^="contact.php"]'));
        }

        links.forEach(link => {
            link.href = new URL(link.getAttribute('href'), productionOrigin).href;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        routeContactLinks(document);

        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        routeContactLinks(node);
                    }
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
    });
}());
