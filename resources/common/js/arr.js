class Arr
{
    /**
     * Determine whether the given value is array accessible.
     *
     * @param  mixed  value
     * @return bool
     */
    static accessible(value) {
        return value instanceof Object || value instanceof Arr;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param {object, array} data The array or object
     * @param {string, number} key The string|number
     * @return bool
     */
    static exist(data, key) {
        if (typeof(key) === "undefined" && key === null) {
            return false;
        }
        
        if (! isNaN(key)){
            key.toString();
        }

        return data.hasOwnProperty(key);
    }

    /**
     * Get an item from an array using "dot" notation.
     * @param {object, array} data The array or object
     * @param {string} key The string
     * @return {mixed} mixed
     */
    static get(data, key) {
        if (! Arr.accessible(data)) {
            throw new Error("Data must be of array or object type");
        }
        if (Arr.exist(data, key)) {
            return data[key];
        }

        if (key.indexOf(".") < 0) {
            throw new Error("Key not found");
        }

        key.split('.').forEach(value=>{
            if (Arr.accessible(data) && Arr.exist(data, value)) {
                data = data[value];
            } else {
                throw new Error("Key not found");
            }
        })

        return data;
    }
}
