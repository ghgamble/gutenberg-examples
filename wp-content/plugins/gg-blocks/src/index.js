import "./index.scss";
import { BaseControl, TextControl, Flex, FlexBlock, FlexItem, Button, Icon } from "@wordpress/components";

(function() {
    let locked = false; // Move to global scope
    wp.data.subscribe(function() {
        const results = wp.data
            .select("core/block-editor")
            .getBlocks()
            .filter(block => block.name === "gg-blocks/multiple-choice" && block.attributes.correctAnswer === undefined);

        if (results.length && locked === false) {
            locked = true;
            wp.data.dispatch("core/editor").lockPostSaving("noanswer");
        }
        if (!results.length && locked) {
            locked = false;
            wp.data.dispatch("core/editor").unlockPostSaving("noanswer");
        }
    });
})();

const EditTestBlock = props => {
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
}

const EditMultipleChoice = (props) => {
    return (
        <div className="multiple-choice-edit-block">
            <BaseControl 
                label={<span style={{ fontSize: "20px", fontWeight: "normal", textTransform: "none" }}>Question:</span>}
            >
                <TextControl 
                    value={props.attributes.question || ""} 
                    onChange={val => props.setAttributes({ question: val })} 
                />
            </BaseControl>
            
            <p style={{ fontSize: "13px", margin: "20px 0 8px 0" }}>Answers:</p>

            {props.attributes.answers.map((answer, index) => {
                return (
                    <Flex key={index}>
                        <FlexBlock>
                            <TextControl
                                value={answer}
                                onChange={val => {
                                    const updatedAnswers = [...props.attributes.answers]; // Copy the array
                                    updatedAnswers[index] = val; // Modify the specific answer
                                    props.setAttributes({ answers: updatedAnswers }); // Save back to attributes
                                }}
                            />
                        </FlexBlock>
                        <FlexItem>
                            <Button onClick={() => props.setAttributes({ correctAnswer: index })}>
                                <Icon 
                                    className="mark-as-correct" 
                                    icon={props.attributes.correctAnswer == index ? "star-filled": "star-empty"} 
                                />
                            </Button>
                        </FlexItem>
                        <FlexItem>
                            <Button 
                                isLink 
                                className="mc-delete"
                                onClick={() => {
                                    const updatedAnswers = props.attributes.answers.filter((_, i) => i !== index);
                                    props.setAttributes({ answers: updatedAnswers });
                                    if(index === props.attributes.correctAnswer) {
                                        props.setAttributes({correctAnswer: undefined});
                                    }
                                }}
                            >
                                Delete
                            </Button>
                        </FlexItem>
                    </Flex>
                );
            })}

            <Button 
                isPrimary
                onClick={() => {
                    props.setAttributes({ answers: [...props.attributes.answers, ""] });
                }}
            >
                Add another answer
            </Button>
        </div>
    )
}


wp.blocks.registerBlockType("gg-blocks/test-block", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "text",
    attributes: {
        skyColor: {type: "string"},
        grassColor: {type: "string"}
    },
    edit: EditTestBlock,
    save: props => {
        return null;
    }
})

wp.blocks.registerBlockType("gg-blocks/multiple-choice", {
    title: "Multiple Choice",
    icon: "smiley",
    category: "text",
    attributes: {
        question: {type: "string"},
        answers: {type: "array", default: [""]},
        correctAnswer: {type: "number", default: undefined}
    },
    edit: EditMultipleChoice,
    save: props => {
        return null;
    }
})

