var gpTool = {
    hexStringToByteArray: function(hexString) {
        let byteArray = [];
        for (let i = 0; i < hexString.length; i += 2) {
            let byte = parseInt(hexString.substr(i, 2), 16);
            byteArray.push(byte);
        }
        return byteArray;
    },
    getDataView: function(value) {
        let uint8Buf = Array.from(value);
        var encodedCmds = new ArrayBuffer(uint8Buf.length)
        var dataView = new DataView(encodedCmds)
        for (var j = 0; j < uint8Buf.length; j++) {
            dataView.setUint8(j, uint8Buf[j]);
        }
        return encodedCmds;
    }
    
}