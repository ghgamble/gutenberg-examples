wp.blocks.registerBlockType("gg-blocks/are-you-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "text",
    attributes: {
        skyColor: {type: "string"},
        grassColor: {type: "string"}
    },
    edit: props => {
        return (
            <div>
                <input 
                    type="text" 
                    placeholder="sky color" 
                    value={props.attributes.skyColor}
                    onChange={e => props.setAttributes({skyColor: e.target.value})} 
                />
                <input 
                    type="text" 
                    placeholder="grass color" 
                    value={props.attributes.grassColor}
                    onChange={e => props.setAttributes({grassColor: e.target.value})} 
                />
            </div>
        )
    },
    save: props => {
        return null;
    }
})