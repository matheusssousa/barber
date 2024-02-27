import { BrowserRouter } from "react-router-dom";
import { AuthProvider } from "./providers/AuthProvider";
import { ConfigsProvider } from "./contexts/ConfigsContext";

import MyRoute from "./routes/MyRoute";
import ThemeProvider from "./contexts/ThemeContext";

function App() {
  return (
    <BrowserRouter>
      {/* <ConfigsProvider> */}
      <AuthProvider>
        <ThemeProvider>
          <MyRoute />
        </ThemeProvider>
      </AuthProvider>
      {/* </ConfigsProvider> */}
    </BrowserRouter>
  )
}

export default App
