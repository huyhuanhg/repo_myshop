// import Validator from '../Validate/Validator.js';

/*export default */
class Hquery {
    #node;
    //all Element
    id;
    class;
    title;
    tagName;
    //Element form
    name;
    //form control
    val;

    constructor(node) {
        if (this.#isNode(node)) {
            this.#node = node;
        } else if (typeof node === 'string') {
            this.#node = document.querySelector(node);
        }
        this.#createProperties();
    }

    /**
     * Attribute
     * @param attribute
     * @param value
     */
    attr(attribute, value = null) {
        if (this.#isElement(this.#node)) {
            if (value === null) {
                return this.#node.getAttribute(attribute);
            } else {
                this.#node.setAttribute(attribute, value);
            }
        }
    }

    val(value = null) {
        if (this.#isElement(this.#node)) {
            if (value === null) {
                return this.val
            } else {
                this.#node.value = value;
            }
        }
    }

    /**
     * events
     * @param callback
     */
    ready(callback) {
        if (this.#node === document) {
            window.onload = callback;
        }
    }

    event(ev, callback) {
        if (this.#isNode(this.#node)) {
            this.#node.addEventListener(ev, function (e) {
                callback(e);
            });
        }
    }

    click(callback) {
        if (this.#isNode(this.#node)) {
            this.#node.onclick = function (ev) {
                callback(ev);
            };
        }
    }

    /**
     * New Element
     * @param elements
     */
    before(elements, isNode = false) {
        if (!this.#isElement(this.#node)) {
            return;
        }
        return this.#insertAside(this.#node, elements, isNode);
    }

    after(elements, isNode = false) {
        if (!this.#isElement(this.#node)) {
            return;
        }
        let siblings = this.#node.nextElementSibling;
        if (siblings === null) {
            return this.#insert(this.#node.parentElement, elements, isNode);
        }
        return this.#insertAside(siblings, elements, isNode);
    }

    append(elements, isNode = false) {
        if (!this.#isElement(this.#node)) {
            return;
        }
        return this.#insert(this.#node, elements, isNode);
    }

    text(text) {
        if (this.#isNode(this.#node)) {
            this.#node.innerText = text;
        }
    }

    html(htmlString) {
        if (this.#isNode(this.#node)) {
            this.#node.innerHTML = htmlString;
        }
    }

    /**
     * validate Form
     */
    validate(options) {
        if (this.tagName !== 'FORM') {
            return;
        }
        new Validator(this.#node, options);
    }

    /**
     * helper private function
     */
    #createProperties() {
        if (this.#isElement(this.#node)) {
            this.id = this.#node.id;
            this.class = this.#node.className;
            this.title = this.#node.title;
            this.tagName = this.#node.tagName;
            if (['FORM', 'INPUT', 'SELECT', 'TEXTAREA', 'BUTTON'].includes(this.tagName)) {
                this.name = this.#node.name;
                if (this.tagName !== 'FORM') {
                    this.val = this.#node.value;
                }
            }
        }
    }

    #insert(parent, elements, isNode) {
        let newNode = this.#createNewNode(elements, isNode);
        parent.append(newNode);
        return newNode;
    }

    #insertAside(childNode, elements, isNode) {
        let parent = childNode.parentElement;
        let newNode = this.#createNewNode(elements, isNode);
        parent.insertBefore(newNode, childNode);
        return newNode;
    }

    #createNewNode(elements, isNode) {
        if (this.#isNode(elements)) {
            return elements;
        } else if (isNode || this.#isTagName(elements)) {
            return document.createElement(elements);
        } else {
            return this.#parseDOM(elements);
        }
    }

    #parseDOM(htmlString) {
        let doc = new DOMParser().parseFromString(htmlString, 'text/html');
        let node = doc.body.firstChild;
        return node;
    }

    #isNode(o) {
        return (
            typeof Node === "object" ? o instanceof Node :
                o && typeof o === "object" && typeof o.nodeType === "number" && typeof o.nodeName === "string"
        );
    }

    #isElement(o) {
        return (
            typeof HTMLElement === "object" ? o instanceof HTMLElement : //DOM2
                o && typeof o === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName === "string"
        );
    }

    #isTagName(tag) {
        let ListTagName = ['a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'bdi', 'bdo', 'blockquote',
            'body', 'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'data', 'datalist', 'dd', 'del', 'details',
            'dfn', 'dialog', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'figcaption', 'figure', 'footer', 'form', 'head', 'header',
            'hgroup', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'html', 'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'keygen', 'label',
            'legend', 'li', 'link', 'main', 'map', 'mark', 'menu', 'menuitem', 'meta', 'meter', 'nav', 'noscript', 'object', 'ol',
            'optgroup', 'option', 'output', 'p', 'param', 'picture', 'pre', 'progress', 'q', 'rp', 'rt', 'ruby', 's', 'samp', 'script',
            'section', 'select', 'small', 'source', 'span', 'strong', 'style', 'sub', 'summary', 'sup', 'svg', 'table', 'tbody', 'td',
            'template', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr', 'track', 'u', 'ul', 'var', 'video', 'wbr'];
        return ListTagName.includes(tag);
    }

    #isNodeList(nodes) {
        return NodeList.prototype.isPrototypeOf(nodes);
    }


}
